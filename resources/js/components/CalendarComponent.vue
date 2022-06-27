<template>
    <div class="container" id="calendarVue">
        <div>
            <b-row class="mb-3">
                <b-col class="">
                    <div>
                        <div>
                            <b-row>
                                <b-col cols="6" style="display: inline-flex">
                                    <b-form-select
                                        v-model="selected"
                                        :options="options"
                                        @change="onChangePlatform($event)"
                                        size="sm"
                                        class="m-3"
                                    ></b-form-select>
                                    <b-form-select
                                        v-model="selectedTimezone"
                                        :options="timezoneOptions"
                                        size="sm"
                                        class="mt-3"
                                    ></b-form-select>
                                </b-col>
                                <b-col
                                    cols="6"
                                    class="px-0"
                                    style="text-align: right"
                                >
                                    <b-row v-if="isLogin == false">
                                        <b-col
                                            sm="2"
                                            md="8"
                                            class=""
                                            style="text-align: right"
                                            ><span></span
                                        ></b-col>
                                        <b-col
                                            sm="10"
                                            md="4"
                                            class=""
                                            style="text-align: center"
                                        >
                                            <b-button
                                                variant="dark"
                                                style="
                                                    background-color: purple;
                                                    width: 100%;
                                                "
                                                @click="login"
                                                >log in</b-button
                                            >
                                            <h6>For Creator</h6>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                        </div>
                    </div>
                </b-col>
            </b-row>
        </div>
        <div>
            <b-row class="mb-3" v-if="isLogin">
                <b-col class="text-right">
                    <div>
                        <b-nav>
                            <b-nav-item active href="/"
                                >All Schedule</b-nav-item
                            >
                            <b-nav-item href="/my-event">My event</b-nav-item>
                            <b-nav-item href="/profile"
                                >My information</b-nav-item
                            >
                        </b-nav>
                    </div>
                </b-col>
            </b-row>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="container">
                        <div class="text-center"></div>
                        <b-overlay :show="show" rounded="sm">
                            <FullCalendar :options="calendarOptions">
                            </FullCalendar>
                        </b-overlay>
                    </div>
                </div>
                <p class="text-right font-weight-bold">
                    How to use this schedule join Discord Here >
                    <a href="https://discord.gg/smPTeJjmkR" target="_blank">
                        <b-img
                            src="/images/round_discord.png"
                            rounded="circle"
                            alt="Circle image"
                            class="underCalendarLogo"
                            style=""
                        ></b-img>
                    </a>
                </p>
            </div>
            <div class="col-md-2">
                <h6>Most Active Collections In 7 days</h6>
                <!-- <p v-for="i in 10">
                    {{ i }}
                    <b-img
                        src="/images/round_discord.png"
                        rounded="circle"
                        alt="Circle image"
                        class="urlLogo"
                        style=""
                    ></b-img>
                    collection name
                </p> -->
                <div class="row" v-for="(user, i) in mostActiveUsers">
                    <div class="col-md-2 col-2 text-center">
                        {{ i + 1 }}
                    </div>
                    <div class="col-md-4 text-center col-4">
                        <b-img
                            :src="user.collection_url"
                            alt="Circle image"
                            class="most-active-user"
                            style=""
                        ></b-img>
                    </div>
                    <div class="col-md-6 col-6">{{user.collection_name}}</div>
                </div>
            </div>
        </div>
        <b-button variant="primary" @click="toggleShow" v-if="false">
            Show overlay
        </b-button>
        <!-- Popup -->
        <div>
            <div>
                <b-modal ref="my-modal" id="my-modal" hide-footer>
                    <template #modal-title size="lg">
                        {{ modalTitle }}
                        <a
                            :href="modalParasUrl"
                            target="_blank"
                            v-if="modalPlatformId == 1"
                        >
                            <b-img
                                src="/images/round_paras.png"
                                rounded="circle"
                                alt="Circle image"
                                class="modalLogo"
                                style=""
                            ></b-img
                        ></a>
                        <a
                            :href="modalCryptoUrl"
                            target="_blank"
                            v-if="modalPlatformId == 4"
                        >
                            <b-img
                                src="/images/round_crypto.png"
                                rounded="circle"
                                alt="Circle image"
                                class="modalLogo"
                                style=""
                            ></b-img
                        ></a>
                        <a
                            :href="modalDiscordUrl"
                            target="_blank"
                            v-if="modalUserRoleId == 2"
                        >
                            <b-img
                                src="/images/round_discord.png"
                                rounded="circle"
                                alt="Circle image"
                                class="modalLogo"
                                style=""
                            ></b-img>
                        </a>
                        <a
                            :href="modalTwitterUrl"
                            target="_blank"
                            v-if="modalUserRoleId == 2"
                        >
                            <b-img
                                src="/images/round_twitter.png"
                                rounded="circle"
                                alt="Circle image"
                                class="modalLogo"
                                style=""
                            ></b-img>
                        </a>
                        <a
                            :href="modalFacebookUrl"
                            target="_blank"
                            v-if="modalUserRoleId == 2"
                        >
                            <b-img
                                src="/images/round_facebook.png"
                                rounded="circle"
                                alt="Circle image"
                                class="modalLogo"
                                style=""
                            ></b-img>
                        </a>                        
                    </template>
                    <div class="d-block text-center">
                        <b-img-lazy
                            v-bind="mainProps"
                            class="w-100"
                            :src="modelImage"
                            alt="Image 1"
                        ></b-img-lazy>
                    </div>
                    <hr />
                    <pre>{{ modalDescription }}</pre>
                    <div v-if="modalUserRoleId == 2">
                        <hr />
                        <h6>Utility</h6>
                        <pre>{{ modalUtility }}</pre>
                    </div>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
import $ from "jquery";
// const $mobile = require("jquery-mobile");
// $.mobile = require('jquery-mobile');
// p $mobile from "jquery-mobile";
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

// window.myFunction = function (arg) {
//   // alert("Yessssss");
//   console.log("arg", arg);
// };

window.mobilecheck = function () {
    var check = false;
    let isIpad =
        /Macintosh/i.test(navigator.userAgent) &&
        navigator.maxTouchPoints &&
        navigator.maxTouchPoints > 1;
    (function (a) {
        if (
            /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ipad|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(
                a
            ) ||
            /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
                a.substr(0, 4)
            ) ||
            isIpad
        )
            check = true;
    })(
        navigator.userAgent || navigator.vendor || window.opera || window.safari
    );
    return check;
};

export default {
    components: {
        FullCalendar, // make the <FullCalendar> tag available
    },
    data() {
        return {
            isLogin: false,
            selectedTimezone: "a",
            timezoneOptions: [{ value: "a", text: "GMT+7" }],
            selected: "1",
            options: [
                { value: "1", text: "Paras" },
                { value: "4", text: "Crypto.com" },
                { value: "2", text: "OpenSea", disabled: true },
                { value: "3", text: "Foundation.app", disabled: true },
                { value: "5", text: "Coming soon", disabled: true },
            ],
            mainProps: {
                center: true,
                fluidGrow: true,
                blank: true,
                blankColor: "#bbb",
                width: 600,
                height: 400,
                class: "my-5",
            },
            events: [],
            token: "",
            show: false,
            kkk: 1000,
            modalTitle: "",
            modelImage: "",
            modalDescription: "",
            modalUserRoleId: "",
            modalParasUrl: "",
            modalTwitterUrl: "",
            modalDiscordUrl: "",
            modalCryptoUrl: "",
            modalFacebookUrl: "",
            modelUserPlatformId: 1,
            mostActiveUsers: [],
            modalUtility: "",
        };
    },
    computed: {
        calendarOptions: function () {
            return {
                longPressDelay: 500,
                selectLongPressDelay: 500,
                selectable: true,
                selectOverlap: false,
                selectHelper: true,
                select: (function () {
                    var humanSelection = true;
                    // return function(start, end, jsEvent, view) {
                    //     if(humanSelection) {
                    //         humanSelection = false;
                    //         $('#calendar').fullCalendar('select', start);
                    //         humanSelection = true;
                    //         $('#id_start_date').val(start.toDate().toUTCString());
                    //         $('#id_end_date').val(end.toDate().toUTCString());
                    //         // Permitir seguir el proceso
                    //         $('#next_button').transition('bounce', 500).removeClass('disabled');
                    //     }
                    // };
                })(),
                height: 650,
                dateClick: this.handleDateClick,
                datesSet: this.handleDateClick2,
                eventClick: this.onClickEvent,
                eventContent: function (arg) {
                    var a = document.createElement("a");
                    $(a)
                        .attr("href", arg.event.extendedProps.paras_url)
                        .attr("id", "xyz")
                        .addClass("example")
                        .text(arg.event._def.title);

                    let socialDisplay =
                        arg.event.extendedProps.roleColor != "text-danger"
                            ? "d-none"
                            : "";
                    let parasIconDisplay =
                        arg.event.extendedProps.platform_id != 1
                            ? "d-none"
                            : "";
                    let cryptoIconDisplay =
                        arg.event.extendedProps.platform_id != 4
                            ? "d-none"
                            : "";
                    var social = document.createElement("div");
                    $(social).append(
                        `
              <div class="row text-center pt-1">
                <div class="col-1 px-0 ">
                </div>     
                <div class="col-2 px-0 ${parasIconDisplay}">
                  <a target="_blank" href="${arg.event.extendedProps.paras_url}">
                    <img src="images/round_paras.png" class="urlLogo rounded"/>
                  </a>
                </div>
                <div class="col-2 px-0 ${cryptoIconDisplay}">
                  <a target="_blank" href="${arg.event.extendedProps.crypto_url}">
                    <img src="images/round_crypto.png" class="urlLogo rounded"/>
                  </a>
                </div>                
                <div class="col-2 px-0 ${socialDisplay}">
                  <a target="_blank" href="${arg.event.extendedProps.discord_url}">
                    <img src="images/round_discord.png" class="urlLogo rounded"/>
                  </a>
                </div>
                <div class="col-2 px-0 ${socialDisplay}">
                  <a target="_blank" href="${arg.event.extendedProps.twitter_url}">
                    <img src="images/round_twitter.png" class="urlLogo rounded"/>
                  </a>             
                </div>
                <div class="col-2 px-0 ${socialDisplay}">
                  <a target="_blank" href="${arg.event.extendedProps.facebook_url}">
                    <img src="images/round_facebook.png" class="urlLogo rounded"/>
                  </a>             
                </div>           
                <div class="col-2 px-0">
                </div>                                                   
              <div>
            `
                    );
                    var topic = document.createElement("div");
                    let imgEventWrap = document.createElement("div");
                    imgEventWrap.setAttribute("id", arg.event.id);
                    imgEventWrap.setAttribute("title", arg.event._def.title);
                    imgEventWrap.setAttribute(
                        "collection",
                        arg.event.extendedProps.collection_url
                    );

                    $(topic).append(
                        `
              <div class="row pt-1" id="event-${arg.event.id}">
                <div class="col-4 px-1 text-center" >
                  <img src=` +
                            arg.event.extendedProps.profile_url +
                            ` class="w-50"/>
                </div>
                <div class="col-8 px-1 text-left" style="overflow: hidden;">
                  <a class="${arg.event.extendedProps.roleColor}">` +
                            arg.event._def.title +
                            `</a> <br>
              <span style="font-size: 70%;">${arg.event.extendedProps.public_time}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
                <small>${arg.event.extendedProps.views}</small>
              <div>
            `
                    );
                    imgEventWrap.append(topic);
                    imgEventWrap.append(social);

                    let $this = this;
                    let arrayOfDomNodes = [imgEventWrap];
                    $(document).ready(function () {
                        // console.log("ready....");
                        // $mobile("#event-" + arg.event.id).tap(function () {
                        //   // console.log("arg--->", arg.event);
                        //   // arg.event.extendedProps.log(
                        //   //   arg.event.title,
                        //   //   arg.event.extendedProps.collection_url
                        //   // );
                        //   alert("ON TAP");
                        // });
                        // console.log("mobile Checking...", window.mobilecheck());
                        if (window.mobilecheck()) {
                            $("#event-" + arg.event.id).on(
                                "touchend",
                                function (event, ui) {
                                    //some code
                                    // console.log("mobile", arg);
                                    // (title, url, description,roleId,parasUrl,twitterUrl,discordUrl)
                                    arg.event.extendedProps.log(
                                        arg.event.title,
                                        arg.event.extendedProps.collection_url,
                                        arg.event.extendedProps.description,
                                        arg.event.extendedProps.role_id,
                                        arg.event.extendedProps.paras_url,
                                        arg.event.extendedProps.twitter_url,
                                        arg.event.extendedProps.discord_url,
                                        arg.event.extendedProps.crypto_url,
                                        arg.event.extendedProps.platform_id,
                                        arg.event.extendedProps.facebook_url,
                                        arg.event.extendedProps.utility
                                    );

                                    // Update event views mobile
                                    arg.event.extendedProps.updateViews(
                                        arg.event.id
                                    );
                                }
                            );
                        } else {
                            $("#event-" + arg.event.id).click(function () {
                                // console.log("PC", arg.event.extendedProps);
                                // (title, url, description,roleId,parasUrl,twitterUrl,discordUrl)
                                arg.event.extendedProps.log(
                                    arg.event.title,
                                    arg.event.extendedProps.collection_url,
                                    arg.event.extendedProps.description,
                                    arg.event.extendedProps.role_id,
                                    arg.event.extendedProps.paras_url,
                                    arg.event.extendedProps.twitter_url,
                                    arg.event.extendedProps.discord_url,
                                    arg.event.extendedProps.crypto_url,
                                    arg.event.extendedProps.platform_id,
                                    arg.event.extendedProps.facebook_url,
                                    arg.event.extendedProps.utility,                                     
                                );
                                // Update event views desktop
                                arg.event.extendedProps.updateViews(
                                    arg.event.id
                                );
                            });
                        }
                    });

                    return { domNodes: arrayOfDomNodes };
                },
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: window.mobilecheck()
                    ? "dayGridDay"
                    : "dayGridWeek",
                defaultView: "basicDay",
                locale: "en",
                weekends: true, // initial value
                events: this.events,
            };
        },
    },
    async mounted() {
        var retrievedObject = localStorage.getItem("accessToken");
        if (retrievedObject) {
            this.isLogin = true;
            retrievedObject = JSON.parse(retrievedObject);
            this.userInfo = retrievedObject.user;
            this.token = retrievedObject.token;
            await this.getUserInfo();
        } else {
            this.isLogin = false;
        }

        if (window.location.pathname == "/paras") {
            this.selected = 1;
            this.fetchEvents(this.selected);
            this.getActiveUserInSevenDay(this.selected)
        } else if (window.location.pathname == "/crypto") {
            this.selected = 4;
            this.fetchEvents(this.selected);
            this.getActiveUserInSevenDay(this.selected);
        }
    },
    methods: {
        login: function () {
            window.location.href = "/login";
        },
        logout: function () {
            localStorage.removeItem("accessToken");
            window.location.href = "/login";
        },
        fetchEvents: function (platformId = 1) {
            // console.log(platformId);
            // someNetworkRequest(fetchInfo.start, fetchInfo.end).then(callback);
            // console.log(arg);
            let $this = this;
            // console.log("handleDateClick2 ----> xxxxx");
            // return;
            var retrievedObject = localStorage.getItem("accessToken");
            if (retrievedObject) {
                this.isLogin = true;
                retrievedObject = JSON.parse(retrievedObject);
                this.userInfo = retrievedObject.user;
                this.token = retrievedObject.token;
                // await this.getUserInfo();
            } else {
                this.isLogin = false;
            }
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };
            let start = "2021-04-04 00:00:00";
            let end = "2023-04-04 00:00:00";
            axios
                .get(
                    `/api/event?start=${start}&end=${end}&platform_id=${platformId}`,
                    config
                )
                .then(function (response) {
                    let result = response.data;
                    $this.overlay = false;
                    $this.show = false;
                    $this.events = [];
                    for (const event of result.data) {
                        // console.log(event);
                        const publicDateTime = event.public_date.split(" ");
                        const timeString = publicDateTime[1];
                        const timeString12hr = new Date(
                            "1970-01-01T" + timeString + "Z"
                        ).toLocaleTimeString("en-US", {
                            timeZone: "UTC",
                            hour12: true,
                            hour: "numeric",
                            minute: "numeric",
                        });
                        // console.log("event --->", event);
                        $this.events.push({
                            id: event.id,
                            title: event.user.collection_name,
                            start: event.public_date,
                            end: event.public_date_end,
                            allDay: false,
                            collection_url: event.collection_url,
                            profile_url: event.user.collection_url,
                            paras_url: event.user.paras_url,
                            twitter_url: event.user.twitter_url,
                            facebook_url: event.user.facebook_url,
                            discord_url: event.user.discord_url,
                            crypto_url: event.user.crypto_url,
                            platform_id: event.user.platform_id,
                            public_time: timeString12hr,
                            views: event.views,
                            roleColor:
                                event.user.role_id == 1
                                    ? "text-primary"
                                    : "text-danger",
                            description: event.description,
                            role_id: event.user.role_id,
                            utility: event.user.utility,
                            log: function (
                                title,
                                url,
                                description,
                                roleId,
                                parasUrl,
                                twitterUrl,
                                discordUrl,
                                cryptoUrl,
                                platformId,
                                facebookUrl,
                                utility
                            ) {
                                $this.modalTitle = title;
                                $this.modelImage = url;
                                $this.modalDescription = description;
                                $this.modalUserRoleId = roleId;
                                $this.modalParasUrl = parasUrl;
                                $this.modalTwitterUrl = twitterUrl;
                                $this.modalDiscordUrl = discordUrl;
                                $this.modalFacebookUrl = facebookUrl;
                                $this.modalCryptoUrl = cryptoUrl;
                                $this.modalPlatformId = platformId;
                                $this.modalUtility = utility;
                                $this.toggleModal();
                            },
                            updateViews: function (eventId) {
                                // console.log("eventId", eventId);
                                // let $this = this;
                                let data = {
                                    event_id: eventId,
                                };
                                axios
                                    .post(`/api/event/views`, data, config)
                                    .then(function (response) {
                                        // console.log(response);
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                    });
                            },
                        });
                    }
                })
                .catch(function (error) {
                    $this.overlay = false;
                    $this.dialog = true;
                    console.log(error);
                });
        },
        onClickEvent: function (arg) {
            // alert("xxxxx");
            /*
                      paras_url: event.user.paras_url,
                    twitter_url: event.user.twitter_url,
                    discord_url: event.user.discord_url,            
            */
            this.modalTitle = arg.event.title;
            this.modelImage = arg.event.extendedProps.collection_url;
            this.modalDescription = arg.event.extendedProps.description;
            this.modalUserRoleId = arg.event.extendedProps.role_id;
            this.modalParasUrl = arg.event.extendedProps.paras_url;
            this.modalTwitterUrl = arg.event.extendedProps.twitter_url;
            this.modalFacebookUrl = arg.event.extendedProps.facebook_url;
            this.modalDiscordUrl = arg.event.extendedProps.discord_url;
            this.modalUtility = arg.event.extendedProps.utility;
            // if (window.mobilecheck()) {
            //   arg.event.extendedProps.log(
            //     arg.event.title,
            //     arg.event.extendedProps.collection_url
            //   );
            // }
        },
        handleDateClick2: function (arg) {
            return;
            var retrievedObject = localStorage.getItem("accessToken");
            if (retrievedObject) {
                this.isLogin = true;
                retrievedObject = JSON.parse(retrievedObject);
                this.userInfo = retrievedObject.user;
                this.token = retrievedObject.token;
                // await this.getUserInfo();
            } else {
                this.isLogin = false;
            }
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };
            this.show = true;
            let $this = this;
            // get event list
            // this.toggleShow();
            // console.log("this.token ---> ", this.token);
            let start = arg.startStr;
            let end = arg.endStr;
            axios
                .get(`/api/event?start=${start}&end=${end}`, config)
                .then(function (response) {
                    // console.log(response);
                    let result = response.data;
                    $this.overlay = false;
                    // $this.userInfo = result.data;
                    // $this.parasUrl = $this.userInfo.paras_url;
                    // $this.discordUrl = $this.userInfo.discord_url;
                    // $this.twitterUrl = $this.userInfo.twitter_url;
                    // $this.collectionName = $this.userInfo.collection_name;
                    // $this.collectionUrl = $this.userInfo.collection_url;
                    $this.show = false;
                    // console.log("loading..LIST.. DONE.", result.data.length);
                    $this.events = [];
                    // for (const event of result.data) {
                    //   console.log("pussss");
                    //   $this.events.push({
                    //     title: "event3",
                    //     start: "2022-04-09T14:30:00",
                    //     collection_url: "https://www.w3schools.com/html/img_girl.jpg",
                    //     paras_url: "https://www.google.com",
                    //     twitter_url: "images/logo.png",
                    //     discord_url: "",
                    //   });
                    // }
                    // $this.calendarOptions.events = $this.events.map((eventnew) => ({
                    //   title: "event3",
                    //   start: "2022-04-09T14:30:00",
                    //   collection_url: "https://www.w3schools.com/html/img_girl.jpg",
                    //   paras_url: "https://www.google.com",
                    //   twitter_url: "images/logo.png",
                    //   discord_url: "",
                    // }));
                    // $this.calendarOptions.events = [
                    //   {
                    //     title: "event3",
                    //     start: "2022-04-09T14:30:00",
                    //     collection_url: "https://www.w3schools.com/html/img_girl.jpg",
                    //     paras_url: "https://www.google.com",
                    //     twitter_url: "images/logo.png",
                    //     discord_url: "",
                    //   }
                    // ]
                })
                .catch(function (error) {
                    $this.overlay = false;
                    $this.dialog = true;
                    console.log(error);
                });
        },
        handleDateClick: function (arg) {},
        toggleWeekends: function () {
            this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
        },
        showModal() {
            this.$refs["my-modal"].show();
        },
        hideModal() {
            this.$refs["my-modal"].hide();
        },
        toggleModal() {
            // We pass the ID of the button that we want to return focus to
            // when the modal has hidden
            this.$refs["my-modal"].toggle("#toggle-btn");
        },
        toggleModalX() {
            // We pass the ID of the button that we want to return focus to
            // when the modal has hidden
            this.$refs["my-modal"].toggle("#toggle-btn");
        },
        handleEventClick() {},
        toggleShow() {
            this.show = !this.show;
        },
        GetCalendarDateRange() {
            var calendar = $("#calendar").fullCalendar("getCalendar");
            var view = calendar.view;
            var start = view.start._d;
            var end = view.end._d;
            var dates = { start: start, end: end };
            return dates;
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
        reloadCalendar: function () {
            // console.log("---->", this.calendarOptions.events);
            // this.calendarOptions.events = []
            this.events = [];
            // this.fetchEvents();
        },
        onChangePlatform(platformId) {
            // console.log("platform_id", platformId);
            // this.events = [];
            // this.fetchEvents(platformId);

            // location.href = "/"
            if (platformId == 1) {
                window.location.href = "/paras";
            } else if (platformId == 4) {
                window.location.href = "/crypto";
            }
        },
        getActiveUserInSevenDay(platformId){
            console.log("get active user...")
            // mostActiveUser

            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };

            axios
                .get(`/api/user/most-active-user/${platformId}`, config)
                .then(function (response) {
                    console.log(response);
                    let result = response.data;
                    $this.mostActiveUsers = result;
                    console.log("$this.mostActiveUser",$this.mostActiveUsers)
                })
                .catch(function (error) {
                    $this.overlay = false;
                });            
        }
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
.modal-title {
    width: 100% !important;
}

/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
    .urlLogo {
        width: 50% !important;
    }
    .modalLogo {
        width: 35%;
        max-width: 15%;
    }
    .underCalendarLogo {
        width: 35%;
        max-width: 10%;
    }
    .most-active-user {
        width: 50% !important;
    }
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
    .urlLogo {
        width: 75% !important;
    }
    .modalLogo {
        width: 35%;
        max-width: 7%;
    }
    .underCalendarLogo {
        width: 35%;
        max-width: 5%;
    }
    .most-active-user {
        width: 100% !important;
    }
}

.fc-daygrid-event{
  display: block!important;
  padding-left: 15px!important;
  background-color:rgb(255 230 255);
  margin-bottom: 10px;
  padding-bottom: 10px;
}
.fc-daygrid-event {
  white-space: normal !important;
  align-items: normal !important;
}
.fc-daygrid-event-dot{
  display: inline-flex;
  position: absolute;
  left: 0px;
  top: 6px;
}
.fc-event-time,.fc-event-title{
  display: inline;
}

</style>
