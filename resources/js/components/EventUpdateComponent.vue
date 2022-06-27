<template>
    <div class="container">
        <div>
            <b-form v-if="true">
                <!-- Image. -->
                <b-row>
                    <b-col cols="4" style="align-items: 1; text-align: end">
                        <p></p
                    ></b-col>
                    <b-col cols="6" class="px-0">
                        <img
                            v-if="collectionUrl"
                            :src="collectionUrl"
                            class="w-50"
                        />
                    </b-col>
                </b-row>
                <b-row class="mt-3">
                    <b-col cols="4" style="align-items: 1; text-align: end">
                        <p>Event picture</p></b-col
                    >
                    <b-col cols="6" class="px-0">
                        <b-form-group
                            id="input-group-1"
                            label=""
                            label-for="input-1"
                            description=""
                        >
                            <b-form-file
                                accept="image/jpeg, image/png, image/gif"
                                v-model="profileImgBase64"
                                :state="Boolean(profileImgBase64)"
                                placeholder=""
                                drop-placeholder=""
                                @change="onFileChange"
                            ></b-form-file>
                            <em>Allowed maximum size is 2 MB</em>
                            <em class="text-danger" v-if="fileSizeExceed">
                                <br />
                                File size exceed maximum allowed size.</em
                            >
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="4" style="align-items: 1; text-align: end">
                        <p>Event date</p></b-col
                    >
                    <b-col cols="6" class="px-0">
                        <b-form-group
                            id="input-group-1"
                            label=""
                            label-for="input-1"
                            description=""
                        >
                            <b-form-datepicker
                                v-model="publicDate"
                                :min="min"
                                :max="max"
                                locale="en"
                                :value="publicDate"
                            ></b-form-datepicker>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row class="mt-3">
                    <b-col cols="4" style="align-items: 1; text-align: end">
                        <p>Event description</p></b-col
                    >
                    <b-col cols="6" class="px-0">
                        <b-form-textarea
                            id="textarea"
                            v-model="description"
                            placeholder="Enter something..."
                            rows="3"
                            max-rows="6"
                        ></b-form-textarea>
                    </b-col>
                </b-row>
                <b-row class="mt-3">
                    <b-col cols="4" style="align-items: 1; text-align: end">
                        <p>Event time</p></b-col
                    >
                    <b-col cols="6" class="px-0">
                        <b-form-group
                            id="input-group-1"
                            label=""
                            label-for="input-1"
                            description=""
                        >
                            <input
                                type="time"
                                name="time"
                                v-model="publicTime"
                            />
                            <!-- <vue-timepicker  v-model="publicTime" ></vue-timepicker> -->
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-form>
        </div>

        <hr />
        <div>
            <b-row>
                <b-col cols="2" style="align-items: 1; text-align: end">
                </b-col>
                <b-col cols="4" class="px-0 text-center">
                    <b-button
                        v-if="onSaving == false"
                        variant="primary"
                        @click="updateEvent()"
                        style="background-color: purple"
                        >update event</b-button
                    >
                    <b-button
                        v-else
                        variant="primary"
                        disabled
                        style="background-color: purple"
                    >
                        <b-spinner small type="grow"></b-spinner>
                        Updating...
                    </b-button>
                </b-col>
                <b-col cols="2 text-center"> </b-col>
            </b-row>
        </div>
        <!-- Popup -->
        <div>
            <div>
                <b-modal
                    ref="my-modal"
                    hide-footer
                    title="Using Component Methods"
                >
                    <div class="d-block text-center">
                        <img src="images/v1.jpg" class="w-100" />
                    </div>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";
import $ from "jquery";
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
export default {
    components: {
        FullCalendar,
        VueTimepicker,
    },
    data() {
        const now = new Date();
        const today = new Date(
            now.getFullYear(),
            now.getMonth(),
            now.getDate()
        );
        // 15th two months prior
        const minDate = new Date(today);
        minDate.setMonth(minDate.getMonth());
        // minDate.setDate(15);
        // 15th in two months
        const maxDate = new Date(today);
        maxDate.setMonth(maxDate.getMonth() + 2);
        maxDate.setDate(15);

        return {
            // show: true,
            // file1: null,
            // file2: null,
            // profileUrl: "",
            profileImgBase64: [],
            collectionUrl: "",
            // collectionName: "",
            // twitterUrl: "",
            // discordUrl: "",
            // parasUrl: "",
            // collectionBase64: "",
            // isLogin: false,
            userInfo: {},
            token: "",
            overlay: false,
            events: [],
            publicDate: "",
            min: minDate,
            max: maxDate,
            publicTime: "",
            eventId: "",
            onSaving: false,
            fileSizeExceed: false,
            description: "",
        };
    },
    async mounted() {
        var eventUrl = window.location.href.split("/");
        this.eventId = eventUrl.slice(-2).shift();
        var retrievedObject = localStorage.getItem("accessToken");
        if (retrievedObject) {
            this.isLogin = true;
            retrievedObject = JSON.parse(retrievedObject);
            this.userInfo = retrievedObject.user;
            this.token = retrievedObject.token;
            await this.getUserInfo();
            await this.getEventInfo(this.eventId);
        } else {
            this.isLogin = false;
            window.location.href = "/";
        }
    },
    methods: {
        onFileChange(e) {
            // console.log("--->");
            const file = e.target.files[0];
            this.collectionUrl = URL.createObjectURL(file);
            // console.log("---->", this.collectionUrl);
            if (file.size > 2000000) {
                this.fileSizeExceed = true;
                this.profileImgBase64 = [];
                this.collectionUrl = "";
                let $this = this;
                setTimeout(function () {
                    $this.fileSizeExceed = false;
                }, 3000);
            } else {
                this.fileSizeExceed = false;
            }
        },
        getUserInfo() {
            let userId = this.userInfo.id;
            let $this = this;
            // console.log("get user info....");
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };

            axios
                .get(`/api/user/${userId}`, config)
                .then(function (response) {
                    // console.log(response);
                    let result = response.data;
                    $this.overlay = false;
                    $this.userInfo = result.data;
                    $this.parasUrl = $this.userInfo.paras_url;
                    $this.discordUrl = $this.userInfo.discord_url;
                    $this.twitterUrl = $this.userInfo.twitter_url;
                    $this.collectionName = $this.userInfo.collection_name;
                    // $this.collectionUrl = $this.userInfo.collection_url;
                })
                .catch(function (error) {
                    $this.overlay = false;
                    $this.dialog = true;
                    console.log(error);
                });
        },
        getEventInfo(eventId) {
            // console.log("eventId ", eventId);
            let $this = this;
            // console.log("get user info....");
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };
            // /api/event/of/:userid
            axios
                .get(`/api/event/${eventId}`, config)
                .then(function (response) {
                    // console.log(response);
                    let result = response.data;
                    // console.log("event kabbbbbb ---> ", result.data);
                    // $this.overlay = false;
                    // $this.userInfo = result.data;
                    // $this.parasUrl = $this.userInfo.paras_url;
                    // $this.discordUrl = $this.userInfo.discord_url;
                    // $this.twitterUrl = $this.userInfo.twitter_url;
                    // $this.collectionName = $this.userInfo.collection_name;
                    // $this.collectionUrl = $this.userInfo.collection_url;
                    $this.event = result.data;
                    // $this.profileImgBase64 =
                    let eventDateTime = result.data.public_date.split(" ");
                    // console.log(" eventDateTime --->", eventDateTime);
                    $this.publicDate = eventDateTime[0];
                    $this.publicTime = eventDateTime[1];
                    $this.collectionUrl = $this.event.collection_url;
                    $this.description = $this.event.description;
                })
                .catch(function (error) {
                    $this.overlay = false;
                    $this.dialog = true;
                    console.log(error);
                });
        },
        updateEvent() {
            // console.log("xxx create event xxxx");
            // console.log("profileImgBase64 ---> ", this.profileImgBase64);
            // console.log("publicDate", this.publicDate);
            // console.log("publiTime", this.publicTime);
            this.onSaving = true;
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };

            // time format...
            // 2022-04-05 00:00:00

            this.overlay = true;
            let userId = this.userInfo.id;
            let body = {
                collection_base64: this.profileImgBase64,
                public_date: `${this.publicDate} ${this.publicTime}`,
                user_id: userId,
                description: this.description
            };

            // return
            var datax = new FormData();
            Object.entries(body).forEach(([key, value]) => {
                datax.append(key, value);
            });

            // console.log("datax", datax);

            let $this = this;
            axios
                .post(`/api/event/${this.eventId}?_method=PUT`, datax, config)
                .then(function (response) {
                    // console.log(response);
                    $this.onSaving = true;
                    let result = response.data;
                    $this.overlay = false;
                    // console.log("update... เรียบร้อยยยยย", result);
                    window.location.href = "/my-event";
                })
                .catch(function (error) {
                    $this.onSaving = true;
                    $this.overlay = false;
                    $this.dialog = true;
                    console.log(error);
                });
        },
    },
};
</script>

<style>
.hide {
    display: none;
}

.myDIV:hover + .hide {
    display: block;
    color: red;
}

.event-thumbnail {
    width: 30%;
    height: 30%;
}
</style>
