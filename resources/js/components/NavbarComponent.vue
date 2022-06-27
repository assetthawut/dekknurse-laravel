<template>
  <div class="container">
    <div class="mb-md-1">
      <b-navbar toggleable="lg" type="dark" variant="">
        <b-navbar-brand href="/" class="text-dark w-50" style="font-weight: 600"
          >Welcome to <br v-if="mobilecheck()"/>
          <span style="color: purple"> World NFTs Event </span></b-navbar-brand
        >

        <b-navbar-toggle
          target="nav-collapse"
          style="overflow-anchor: none; background-color: purple"
        ></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <!-- Right aligned nav items -->
          <b-navbar-nav class="ml-auto" v-if="isLogin">
            <b-nav-item-dropdown right>
              <!-- Using 'button-content' slot -->
              <template #button-content>
                <em style="color: black">{{ fullname }}</em>
              </template>
              <b-dropdown-item
                href="/profile"
                class="text-dark w-100"
                style="color: black"
                >Profile</b-dropdown-item
              >
              <b-dropdown-item
                href="#"
                class="text-dark w-100"
                @click="logout"
                style="color: black"
                >Sign Out</b-dropdown-item
              >
            </b-nav-item-dropdown>
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>
    </div>
    <div>
      <b-row class="mb-3" align-v="">
        <b-col class="">
          <div>
            <div>
              <b-row>
                <b-col cols="6" style="display: inline-flex">
                  <b-form-select
                    v-model="selected"
                    :options="options"
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
                <b-col cols="6" class="px-0" style="text-align: right">
                  <b-row v-if="isLogin == false">
                    <b-col sm="2" md="8" class="" style="text-align: right"
                      ><span></span
                    ></b-col>
                    <b-col sm="10" md="4" class="" style="text-align: center">
                      <b-button
                        variant="dark"
                        style="background-color: purple; width: 100%"
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
      <b-row class="mb-3" align-v="" v-if="isLogin">
        <b-col class="text-right">
          <div>
            <b-nav>
              <b-nav-item active href="/">All Schedule</b-nav-item>
              <b-nav-item href="/my-event">My event</b-nav-item>
              <b-nav-item href="/profile">My information</b-nav-item>
            </b-nav>
          </div>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
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
      selectedTimezone: "a",
      timezoneOptions: [{ value: "a", text: "GMT+7" }],
      selected: "1",
      options: [
        { value: "1", text: "Paras" },
        { value: "4", text: "Crypto.com"},
        { value: "2", text: "OpenSea", disabled: true },
        { value: "3", text: "Foundation.app", disabled: true },
        { value: "5", text: "Coming soon", disabled: true },
      ],
      fullname: "xxxx xxxxx",
      username: "",
      password: "",
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        weekends: false, // initial value
      },
      userInfo: {},
      token: "",
      isLogin: false,
    };
  },
  mounted() {
    var retrievedObject = localStorage.getItem("accessToken");
    if (retrievedObject) {
      this.isLogin = true;
      retrievedObject = JSON.parse(retrievedObject);
      this.userInfo = retrievedObject.user;
      this.token = retrievedObject.token;
      this.fullname =
        this.userInfo && this.userInfo?.name
          ? `${this.userInfo?.name}`
          : "Login";
    } else {
      this.isLogin = false;
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
    onSubmit: function () {
      axios
        .post("/api/user/login", {
          username: this.username,
          password: this.password,
        })
        .then(function (response) {
          // console.log(response);
          localStorage.setItem("userToken", response.data.data.token);
          // console.log(localStorage.getItem('userToken'))
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    mobilecheck: function () {
      var check = false;
      (function (a) {
        if (
          /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(
            a
          ) ||
          /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
            a.substr(0, 4)
          )
        )
          check = true;
      })(navigator.userAgent || navigator.vendor || window.opera);
      return check;
    },
  },
};
</script>
