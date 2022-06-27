<template>
  <div class="container">
    <b-container>
      <div class="">
        <b-row class="mt-5" align-v="center">
          <b-col cols="2"></b-col>
          <b-col cols="8" class="" style="text-align: center">
            <h6>
              Powered by "Chingchong"
              <b-img
                src="/images/chingchong.jpg"
                rounded="circle"
                alt="Circle image"
                class="footerLogo"
                style=""
              ></b-img></h6
          ></b-col>
          <b-col cols="2"></b-col>
        </b-row>
        <b-row class="mt-1 text-center" align-v="center">
          <b-col cols="2"></b-col>
          <b-col cols="8">
            <p>
              <a href="https://paras.id/wis_ktl.near/creation" target="_blank">
                <b-img
                  src="/images/paras.png"
                  rounded="circle"
                  alt="Circle image"
                  class="footerLogo"
                  style=""
                ></b-img
              ></a>
              <a href="https://discord.gg/smPTeJjmkR" target="_blank">
                <b-img
                  src="/images/discord.png"
                  rounded="circle"
                  alt="Circle image"
                  class="footerLogo"
                  style=""
                ></b-img>
              </a>
              <a href="https://twitter.com/Wisktl" target="_blank">
                <b-img
                  src="/images/twitter.png"
                  rounded="circle"
                  alt="Circle image"
                  class="footerLogo"
                  style=""
                ></b-img>
              </a>
              <a href="https://www.instagram.com/wisktl/" target="_blank">
                <b-img
                  src="/images/instagram.png"
                  rounded="circle"
                  alt="Circle image"
                  class="footerLogo"
                  style=""
                ></b-img>
              </a>
            </p>
          </b-col>
          <b-col cols="2"></b-col>
        </b-row>
      </div>
    </b-container>
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
      username: "",
      password: "",
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        weekends: false, // initial value
      },
    };
  },
  mounted() {},
  methods: {
    onSubmit: function () {
      // console.log("---->");
      // console.log("username", this.username);
      // console.log("password", this.password);
      axios
        .post("/api/user/login", {
          username: this.username,
          password: this.password,
        })
        .then(function (response) {
          // console.log(response);
          localStorage.setItem(
            "accessToken",
            JSON.stringify(response.data.data)
          );
          var retrievedObject = localStorage.getItem("accessToken");
          // console.log("accessToken: ", JSON.parse(retrievedObject));
          window.location.href = "/";
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>
<style>
/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
  .footerLogo {
    /* width: 50% !important; */
    width: 35%;
    max-width: 15%;
  }
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
  .footerLogo {
    /* width: 75% !important; */
    width: 35%;
    max-width: 5%;
  }
}
</style>