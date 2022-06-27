<template>
  <div class="container">
    <div>
      <!-- Image. -->
      <b-row v-for="event in events" v-bind:key="event.id">
        <b-col cols="2" style="align-items: 1; text-align: end">
          <p>Date {{ event.public_date }}</p></b-col
        >
        <b-col cols="4" class="px-0 text-center">
          <img :src="event.collection_url" class="w-25" />
        </b-col>
        <b-col cols="2 text-center">
          <b-row>
            <b-col cols="12">
              <b-button
                variant="primary"
                :href="'/event/' + event.id + '/edit'"
                style="width: 100%; background-color: grey !important"
                >Edit</b-button
              >
            </b-col>
          </b-row>
          <b-row>
            <b-col cols="12 mt-2">
              <b-icon
                icon="trash"
                style="color: red"
                @click="deleteEvent(event.id)"
              ></b-icon>
            </b-col>
          </b-row>
          <!-- <b-button variant="danger" @click="deleteEvent(event.id)"
            >Delete</b-button
          > -->
        </b-col>
      </b-row>
    </div>

    <hr />
    <div>
      <b-row>
        <b-col cols="2" style="align-items: 1; text-align: end"> </b-col>
        <b-col cols="4" class="px-0 text-center">
          <b-button
            :disabled="disableCreateButton"
            variant="primary"
            @click="gotoEventForm()"
            style="background-color: purple"
            >Add new event</b-button
          >
        </b-col>
        <b-col cols="2 text-center"> </b-col>
      </b-row>
    </div>
    <!-- Popup -->
    <div>
      <div>
        <b-modal ref="my-modal" hide-footer title="Using Component Methods">
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
      // show: true,
      // file1: null,
      // file2: null,
      // profileUrl: "",
      // profileImgBase64: [],
      // collectionUrl: "",
      // collectionName: "",
      // twitterUrl: "",
      // discordUrl: "",
      // parasUrl: "",
      // collectionBase64: "",
      // isLogin: false,
      userInfo: {},
      token: "",
      // overlay: false,
      events: [],
      disableCreateButton: false,
    };
  },
  async mounted() {
    var retrievedObject = localStorage.getItem("accessToken");
    if (retrievedObject) {
      this.isLogin = true;
      retrievedObject = JSON.parse(retrievedObject);
      this.userInfo = retrievedObject.user;
      this.token = retrievedObject.token;
      await this.getUserInfo();
      await this.getEventList();
    } else {
      this.isLogin = false;
      window.location.href = "/";
    }
  },
  methods: {
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
    // onFileChange(e) {
    //   console.log("--->");
    //   const file = e.target.files[0];
    //   this.collectionUrl = URL.createObjectURL(file);
    //   console.log("---->", this.collectionUrl);
    //   // this.profileUrl = URL.createObjectURL(this.profileImgBase64);
    //   // console.log("--->",this.profileUrl)
    // },
    // saveProfile: function () {
    //   const config = {
    //     headers: {
    //       "Content-type": "application/json",
    //       Authorization: `Bearer ${this.token}`,
    //     },
    //   };
    //   console.log("save profile");
    //   console.log("--->", this.profileImgBase64);
    //   this.overlay = true;
    //   let body = {
    //     paras_url: this.parasUrl,
    //     discord_url: this.discordUrl,
    //     twitter_url: this.twitterUrl,
    //     collection_name: this.collectionName,
    //     collection_base64: this.profileImgBase64,
    //   };
    //   let userId = this.userInfo.id;
    //   console.log("body ---> ", body);
    //   console.log("userId ---> ", userId);
    //   var datax = new FormData();
    //   Object.entries(body).forEach(([key, value]) => {
    //     datax.append(key, value);
    //   });
    //   let $this = this;
    //   axios
    //     .post(
    //       `/api/profile/${userId}?_method=PUT`,
    //       datax,
    //       config
    //     )
    //     .then(function (response) {
    //       console.log(response);
    //       let result = response.data;
    //       $this.overlay = false;
    //       console.log("update...", result);
    //     })
    //     .catch(function (error) {
    //       $this.overlay = false;
    //       $this.dialog = true;
    //       console.log(error);
    //     });
    // },
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
          $this.collectionUrl = $this.userInfo.collection_url;
        })
        .catch(function (error) {
          $this.overlay = false;
          $this.dialog = true;
          console.log(error);
        });
    },
    getEventList() {
      let userId = this.userInfo.id;
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
        .get(`/api/event/of/${userId}`, config)
        .then(function (response) {
          // console.log(response);
          let result = response.data;
          // console.log("event list ---> ", result.data);
          // $this.overlay = false;
          // $this.userInfo = result.data;
          // $this.parasUrl = $this.userInfo.paras_url;
          // $this.discordUrl = $this.userInfo.discord_url;
          // $this.twitterUrl = $this.userInfo.twitter_url;
          // $this.collectionName = $this.userInfo.collection_name;
          // $this.collectionUrl = $this.userInfo.collection_url;
          $this.events = result.data;
          const maxNormalUserEvent = 2;
          const maxExclusiveUserEvent = 5;
          // console.log("userInfo.role_id--->", $this.userInfo.role_id);
          // console.log("$this.events.length --->", $this.events.length);
          if ($this.userInfo.role_id == 2) {
            if ($this.events.length >= maxExclusiveUserEvent) {
              $this.disableCreateButton = true;
            }else{
              $this.disableCreateButton = false;
            }
          }
          if ($this.userInfo.role_id == 1) {
            if ($this.events.length >= maxNormalUserEvent) {
              $this.disableCreateButton = true;
            }else{
              $this.disableCreateButton = false;
            }
          }
          // console.log(
          //   "$this.disableCreateButton 55555555",
          //   $this.disableCreateButton
          // );
        })
        .catch(function (error) {
          $this.overlay = false;
          $this.dialog = true;
          console.log(error);
        });
    },
    gotoEventForm() {
      // console.log("create event");
      window.location.href = "/event/create";
    },
    deleteEvent(eventId) {
      if (confirm("Do you really want to delete?")) {
        // console.log("delete.....");
        const config = {
          headers: {
            "Content-type": "application/json",
            Authorization: `Bearer ${this.token}`,
          },
        };

        // console.log("config --> ", config);

        // time format...
        // 2022-04-05 00:00:00

        this.overlay = true;
        let userId = this.userInfo.id;
        let $this = this;
        axios
          .delete(`/api/event/${eventId}`, config)
          .then(function (response) {
            // console.log(response);
            let result = response.data;
            $this.overlay = false;
            // console.log("ลบเรียนร้อยยยยยย...", result);
            $this.getEventList();
          })
          .catch(function (error) {
            $this.overlay = false;
            $this.dialog = true;
            console.log(error);
          });
      }
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
.btn-primary:disabled,
.btn-primary.disabled {
  color: #dee2e6;
  background-color: #adb5bd !important;
  border-color: #f9fafb;
}
</style>
