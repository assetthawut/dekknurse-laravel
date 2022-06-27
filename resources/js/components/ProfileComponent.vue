<template>
    <div class="container">
        <div>
            <!-- <b-form v-if="true"> -->
            <!-- Image. -->
            <b-row>
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p></p
                ></b-col>
                <b-col cols="6" class="px-0">
                    <!-- <img v-if="collectionUrl" :src="collectionUrl" class="w-50" /> -->
                    <b-img-lazy
                        v-if="collectionUrl"
                        v-bind="mainProps"
                        :src="collectionUrl"
                        style="max-width: 10rem"
                        alt="Image 1"
                    ></b-img-lazy>
                </b-col>
            </b-row>
            <b-row class="mt-3">
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Collection picture profile</p></b-col
                >
                <b-col cols="6" class="px-0">
                    <b-form-group
                        id="input-group-1"
                        label=""
                        label-for="input-1"
                        description=""
                    >
                        <b-form-file
                            v-model="profileImgBase64"
                            accept="image/jpeg, image/png, image/gif"
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
            <!-- Collection name -->
            <b-row>
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Collection name</p></b-col
                >
                <b-col cols="6" class="px-0">
                    <b-form-group
                        id="input-group-1"
                        label=""
                        label-for="input-1"
                        description=""
                    >
                        <b-form-input
                            v-model="collectionName"
                            id="input-1"
                            type="text"
                            placeholder=""
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <!-- Utility option -->
            <b-row>
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Utility</p></b-col
                >
                <b-col cols="6" class="px-0">
                        <b-form-textarea
                            :disabled="isExclusiveUser == false"
                            id="textarea"
                            v-model="utility"
                            placeholder="Enter something..."
                            rows="3"
                            max-rows="6"
                        ></b-form-textarea>
                        <span class="text-danger"
                            >(only Chingchong Holder 1:1)</span
                        >                        
                </b-col>
            </b-row>
            <!-- Platform option -->
            <b-row class="mt-2">
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Platform</p></b-col
                >
                <b-col cols="6" class="px-0">
                    <b-form-select
                        v-model="selected"
                        :options="options"
                    ></b-form-select>
                </b-col>
            </b-row>
            <!-- Paras Link -->
            <b-row class="mt-1" v-if="userPlatformId == 1">
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Paras link</p></b-col
                >
                <b-col cols="6" class="px-0">
                    <b-form-group
                        id="input-group-2"
                        label=""
                        label-for="input-2"
                        description=""
                    >
                        <b-form-input
                            v-model="parasUrl"
                            id="input-2"
                            type="text"
                            placeholder=""
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <!-- Crypto Link -->
            <b-row class="mt-1" v-if="userPlatformId == 4">
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Crypto link</p></b-col
                >
                <b-col cols="6" class="px-0">
                    <b-form-group
                        id="input-group-2"
                        label=""
                        label-for="input-2"
                        description=""
                    >
                        <b-form-input
                            v-model="cryptoUrl"
                            id="input-2"
                            type="text"
                            placeholder=""
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>            
            <!-- Discord Link -->
            <b-row class="mt-1">
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Discord link</p></b-col
                >
                <b-col cols="6" class="px-0">
                    <b-form-group
                        id="input-group-3"
                        label=""
                        label-for="input-3"
                        description=""
                    >
                        <b-form-input
                            :disabled="isExclusiveUser == false"
                            v-model="discordUrl"
                            id="input-3"
                            type="text"
                            placeholder=""
                            required
                        ></b-form-input>
                        <span class="text-danger"
                            >(only Chingchong Holder 1:1)</span
                        >
                    </b-form-group>
                </b-col>
            </b-row>
            <!-- Twitter Link -->
            <b-row class="mt-1">
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Twitter link</p></b-col
                >
                <b-col cols="6" class="px-0">
                    <b-form-group
                        id="input-group-3"
                        label=""
                        label-for="input-3"
                        description=""
                    >
                        <b-form-input
                            :disabled="isExclusiveUser == false"
                            v-model="twitterUrl"
                            id="input-3"
                            type="text"
                            placeholder=""
                            required
                        ></b-form-input>
                        <span class="text-danger"
                            >(only Chingchong Holder 1:1)</span
                        >
                    </b-form-group>
                </b-col>
            </b-row>
            <!-- Facebook Link -->
            <b-row class="mt-1">
                <b-col cols="4" style="align-items: 1; text-align: end">
                    <p>Facebook link</p></b-col
                >
                <b-col cols="6" class="px-0">
                    <b-form-group
                        id="input-group-3"
                        label=""
                        label-for="input-3"
                        description=""
                    >
                        <b-form-input
                            :disabled="isExclusiveUser == false"
                            v-model="facebookUrl"
                            id="input-3"
                            type="text"
                            placeholder=""
                            required
                        ></b-form-input>
                        <span class="text-danger"
                            >(only Chingchong Holder 1:1)</span
                        >
                    </b-form-group>
                </b-col>
            </b-row>            
            <div class="mt-3">
                <b-row class="mt-1">
                    <b-col cols="4" style="align-items: 1; text-align: end">
                    </b-col>
                    <b-col cols="6" class="px-0">
                        <b-button
                            v-if="onSaving == false"
                            type="button"
                            variant="primary"
                            @click="saveProfile"
                            style="background-color: purple"
                            >Save</b-button
                        >
                        <b-button
                            v-else
                            variant="primary"
                            disabled
                            style="background-color: purple"
                        >
                            <b-spinner small type="grow"></b-spinner>
                            Saving...
                        </b-button>
                        <!-- <b-button type="reset" variant="danger">Edit</b-button> -->
                    </b-col>
                </b-row>
            </div>
            <!-- </b-form> -->
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
import $ from "jquery";
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
export default {
    components: {
        FullCalendar, // make the <FullCalendar> tag available
    },
    data() {
        return {
            selected: "1",
            options: [
                { value: "1", text: "Paras", disabled: true },
                { value: "2", text: "OpenSea", disabled: true },
                { value: "3", text: "Foundation.app", disabled: true },
                { value: "4", text: "Crypto.com", disabled: true },
                { value: "5", text: "Coming soon", disabled: true },
            ],
            mainProps: {
                center: true,
                fluidGrow: true,
                blank: true,
                blankColor: "#bbb",
                class: "w-50",
            },
            show: true,
            file1: null,
            file2: null,
            profileUrl: "",
            profileImgBase64: [],
            collectionUrl: "",
            collectionName: "",
            twitterUrl: "",
            discordUrl: "",
            parasUrl: "",
            collectionBase64: "",
            isLogin: false,
            userInfo: {},
            token: "",
            overlay: false,
            isExclusiveUser: false,
            onSaving: false,
            counter: 0,
            fileSizeExceed: false,
            cryptoUrl: "",
            userPlatformId: "",
            facebookUrl:"",
            utility:""
        };
    },
    async mounted() {
        var retrievedObject = localStorage.getItem("accessToken");
        if (retrievedObject) {
            this.isLogin = true;
            retrievedObject = JSON.parse(retrievedObject);
            this.userInfo = retrievedObject.user;

            if (this.userInfo.role_id == 2) {
                this.isExclusiveUser = true;
            }
            this.token = retrievedObject.token;
            await this.getUserInfo();
        } else {
            this.isLogin = false;
            window.location.href = "/";
        }
    },
    methods: {
        toast(toaster, append = false) {
            this.counter++;
            this.$bvToast.toast(`Toast ${this.counter} body content`, {
                title: `Toaster ${toaster}`,
                toaster: toaster,
                solid: true,
                appendToast: append,
            });
        },
        // onClickEvent: function (arg) {
        //   console.log("on click event", arg);
        //   console.log(this.kkk);
        //   this.toggleModal();
        // },
        // handleDateClick2: function (arg) {
        //   console.log(arg);
        //   this.toggleShow();
        // },
        // handleDateClick: function (arg) {
        //   console.log(arg);
        // },
        // toggleWeekends: function () {
        //   this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
        // },
        // showModal() {
        //   this.$refs["my-modal"].show();
        // },
        // hideModal() {
        //   this.$refs["my-modal"].hide();
        // },
        // toggleModal() {
        //   // We pass the ID of the button that we want to return focus to
        //   // when the modal has hidden
        //   this.$refs["my-modal"].toggle("#toggle-btn");
        // },
        // handleEventClick() {
        //   console.log("---->");
        //   // console.log(this.kkk)
        // },
        // toggleShow() {
        //   console.log("showww", this.show);
        //   this.show = !this.show;
        // },
        onFileChange(e) {
            const file = e.target.files[0];
            this.collectionUrl = URL.createObjectURL(file);
            // 2000000 == 2 MB
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
            // this.profileUrl = URL.createObjectURL(this.profileImgBase64);
            // console.log("--->",this.profileUrl)
        },

        saveProfile: function () {
            let notificationSuccessToast = (vm, append = false) => {
                vm.$bvToast.toast(`Update user profile`, {
                    title: "Update user profile successfully",
                    autoHideDelay: 3000,
                    appendToast: append,
                    variant: "success",
                });
            };

            let notificationErrorToast = (vm, append = false) => {
                vm.$bvToast.toast(`Update user profile`, {
                    title: "Someting went wrong",
                    autoHideDelay: 3000,
                    appendToast: append,
                    variant: "danger",
                });
            };
            this.onSaving = true;
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };
            this.overlay = true;
            let body = {
                paras_url: this.parasUrl,
                discord_url: this.discordUrl,
                twitter_url: this.twitterUrl,
                crypto_url: this.cryptoUrl,
                facebook_url: this.facebookUrl,
                collection_name: this.collectionName,
                collection_base64: this.profileImgBase64,
                platform_id: this.selected,
                utility: this.utility
            };

            let userId = this.userInfo.id;
            var datax = new FormData();
            Object.entries(body).forEach(([key, value]) => {
                datax.append(key, value);
            });
            let $this = this;
            axios
                .post(`/api/profile/${userId}?_method=PUT`, datax, config)
                .then(function (response) {
                    notificationSuccessToast($this, true);
                    let result = response.data;
                    $this.overlay = false;
                    $this.onSaving = false;
                })
                .catch(function (error) {
                    notificationErrorToast($this, true);
                    $this.overlay = false;
                    $this.dialog = true;
                    $this.onSaving = false;
                    console.log(error);
                });
        },
        getUserInfo() {
            let userId = this.userInfo.id;
            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };

            axios
                .get(`/api/user/${userId}`, config)
                .then(function (response) {
                    let result = response.data;
                    $this.overlay = false;
                    $this.userInfo = result.data;
                    $this.parasUrl = $this.userInfo.paras_url;
                    $this.selected = $this.userInfo.platform_id;
                    $this.userPlatformId = $this.userInfo.platform_id;
                    $this.discordUrl =
                        $this.userInfo.discord_url &&
                        $this.userInfo.discord_url != "null"
                            ? $this.userInfo.discord_url
                            : "";
                    $this.twitterUrl =
                        $this.userInfo.twitter_url &&
                        $this.userInfo.twitter_url != "null"
                            ? $this.userInfo.twitter_url
                            : "";
                    $this.cryptoUrl =
                        $this.userInfo.crypto_url &&
                        $this.userInfo.crypto_url != "null"
                            ? $this.userInfo.crypto_url
                            : "";                            
                    $this.collectionName = $this.userInfo.collection_name;
                    $this.collectionUrl = $this.userInfo.collection_url;
                    $this.facebookUrl =
                        $this.userInfo.facebook_url &&
                        $this.userInfo.facebook_url != "null"
                            ? $this.userInfo.facebook_url
                            : "";        
                    $this.utility =
                        $this.userInfo.utility &&
                        $this.userInfo.utility != "null"
                            ? $this.userInfo.utility
                            : "";                                        
                })
                .catch(function (error) {
                    $this.overlay = false;
                    $this.dialog = true;
                    console.log(error);
                });
        },
        uploadImages(event) {
            let image_id = Math.floor(
                Math.random() * (1000000 - 1000 + 1) + 1000
            );
            let name = "image_" + image_id;
            let imageData = null;
            let context = null;
            let maxWidth = 1024;
            let maxHeigt = 768;
            let width = maxWidth;
            let height = maxHeigt;
            let vm = this;
            let files = event.target.files;
            vm.imageIndex = 0;

            let formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                let reader = new FileReader();
                let file = files[i];

                if (!file.type.match("image")) continue;
                if (file.type == "image/gif") {
                    this.collectionUrl = URL.createObjectURL(file);
                    this.profileImgBase64 = file;
                } else {
                    var img = document.createElement("img");
                    var canvas = $("<canvas/>").get(0);
                    reader.onload = function (e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    let $this = this;
                    img.onload = function () {
                        // Draw
                        context = canvas.getContext("2d");
                        context.drawImage(img, 0, 0);
                        if (img.width > maxWidth || img.height > maxHeigt) {
                            width = maxWidth;
                            height = maxHeigt;

                            if (img.width > maxWidth) {
                                width = maxWidth;
                                var ration = maxWidth / img.width;
                                height = Math.round(img.height * ration);
                            }

                            if (img.height > maxHeigt) {
                                height = maxHeigt;
                                var ration = maxHeigt / img.height;
                                width = Math.round(img.width * ration);
                            }
                        } else {
                            width = img.width;
                            height = img.height;
                        }
                        canvas.width = width;
                        canvas.height = height;

                        context.drawImage(img, 0, 0, width, height);
                        imageData = canvas.toDataURL("image/jpeg");
                        imageData.replace("data:image/jpeg;base64,", "");

                        let blobToFile = vm.dataURItoBlob(imageData);
                        const cfile = new File([blobToFile], name + ".jpg", {
                            type: "image/jpeg",
                            lastModified: Date.now(),
                        });
                        $this.profileImgBase64 = cfile;
                        // console.log("this.profileImgBase64 --->", $this.profileImgBase64);
                        const file = event.target.files[0];
                        $this.collectionUrl = URL.createObjectURL(cfile);
                        // console.log("this.collectionUrl", $this.collectionUrl);
                    };
                }
            }
        },

        dataURItoBlob(dataURI) {
            // convert base64 to raw binary data held in a string
            var byteString = atob(dataURI.split(",")[1]);
            // separate out the mime component
            var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];
            // write the bytes of the string to an ArrayBuffer
            var arrayBuffer = new ArrayBuffer(byteString.length);
            var _ia = new Uint8Array(arrayBuffer);
            for (var i = 0; i < byteString.length; i++) {
                _ia[i] = byteString.charCodeAt(i);
            }
            var dataView = new DataView(arrayBuffer);
            var blob = new Blob([dataView], { type: mimeString });
            return blob;
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
