<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>
          <button
            type="button"
            class="btn btn-lg btn-danger"
            data-toggle="popover"
            title="Popover title"
            data-content="And here's some amazing content. It's very engaging. Right?"
          >
            Click to toggle popover
          </button>
          <div class="card-body">I'm an example component xxxx.</div>
          <!-- <font-awesome-icon :icon="['fas', 'archway']" /> -->
          <!-- <font-awesome-icon :icon="['fas', 'user-secret']" /> -->
          <!-- <font-awesome-icon icon="user-secret"></font-awesome-icon> -->
          <font-awesome-icon :icon="['fas', 'user-secret']" />
          <font-awesome-icon :icon="['fas', '']" />
          <i class="fa-brands fa-youtube"></i>
          ssssss
          <button @click="toggleWeekends">toggle weekends</button>
          <FullCalendar :options="calendarOptions">
            <template>
              <b>KKK</b>
              <i>yyyy</i>
            </template>
          </FullCalendar>
        </div>
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
      calendarOptions: {
        eventClick: function (info) {
          // console.log("info ---> ", info);
          // console.log("Event: " + info.event.title);
          // console.log(
          //   "Coordinates: " + info.jsEvent.pageX + "," + info.jsEvent.pageY
          // );
          // console.log("View: " + info.view.type);

          // change the border color just for fun
          info.el.style.borderColor = "red";
        },
        eventContent: function (arg) {
          // if (event.icon) {
          // console.log("arg", arg);
          let titleEvent = document.createElement("div");
          if (arg.event._def.title) {
            titleEvent.innerHTML = arg.event._def.title;
            titleEvent.classList = "myDIV";
            // $('myDIV').insert('<li>text</li>');
            let str =
              "hello, <b>my name is</b> jQuery. <font-awesome-icon icon='user-secret' ></font-awesome-icon> kkkk";
            let html = $.parseHTML(str);
            titleEvent.append(html);
          }
          let str =
            "<template> <font-awesome-icon icon='user-secret' ></font-awesome-icon> </template> kkkk";
          let html = $.parseHTML(str);
          // console.log("html", html);
          titleEvent.append(html);
          var e = $(
            "<ul><li><div class='bar'>bla <i class='fa-brands fa-youtube'></i> <template> <font-awesome-icon icon='user-secret' ></font-awesome-icon> </template>  </div></li></ul> "
          );
          let kkk = $("li", e).attr("id", "a1234"); // set the attribute

          var component = {
            template:
              '<font-awesome-icon icon="align-right" />',
          };

          // <font-awesome-icon icon="fa-brands fa-discord" />

          Vue.component("my-component", component);
          var myComponent = Vue.extend(component);
          var component = new myComponent().$mount();

          // $("#app").append(component.$el);

          // $("body").append(component.$el); // put it into the DOM
          // html.append(component.$el);

        var a = document.createElement('a');
        $(a).attr('href','index.html').attr('id','xyz').addClass('example').text("dasdasdasd");

          let arrayOfDomNodes = [a,component.$el];
          return { domNodes: arrayOfDomNodes };

          // arg.element
          //   .find(".fc-event-title")
          //   .prepend('<font-awesome-icon icon="user-secret" ></font-awesome-icon>');
          // }
          // console.log("--->", arg);
          // let arrayOfDomNodes = [];
          // // title event
          // let titleEvent = document.createElement("div");
          // if (arg.event._def.title) {
          //   titleEvent.innerHTML = arg.event._def.title;
          //   titleEvent.classList = "myDIV";
          // }
          // // image event
          // let imgEventWrap = document.createElement("a");
          // if (arg.event.extendedProps.image_url) {
          //   let imgEvent =
          //     '<img src="' +
          //     arg.event.extendedProps.image_url +
          //     '" style="/* position: absolute; */position: fixed;top: 50%;left: 50%; /* bring your own prefixes */transform: translate(-50%, -50%); z-index: 1000;">';
          //   imgEventWrap.classList = "hide";
          //   imgEventWrap.innerHTML = imgEvent;
          // }

          // var z = document.createElement("font-awesome-icon"); // is a node
          // z.setAttribute("icon", "user-secret");
          // // z.insertAdjacentHTML =
          // //   '<font-awesome-icon icon="user-secret" ></font-awesome-icon>';
          // // document.body.appendChild(z);

          // arrayOfDomNodes = [z, titleEvent, imgEventWrap];
          // console.log("arrayOfDomNodes", arrayOfDomNodes);

          // // <div class="myDIV">Hover over me.</div>
          // // <div class="hide">I am shown when someone hovers over the div above.</div>

          // return { domNodes: arrayOfDomNodes };
        },
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridWeek",
        locale: "th",
        weekends: true, // initial value
        events: [
          {
            title: "event3",
            start: "2022-03-29T12:30:00",
            image_url: "https://www.w3schools.com/html/img_girl.jpg",
          },
          {
            title: "event3",
            start: "2022-03-01T09:30:00",
            image_url: "https://www.w3schools.com/html/img_girl.jpg",
          },
          {
            title: "event3",
            start: "2022-03-30T09:30:00",
            image_url: "https://www.w3schools.com/html/img_girl.jpg",
          },
          {
            title: "event3",
            start: "2022-03-31T09:30:00",
            image_url: "https://www.w3schools.com/html/img_girl.jpg",
          },
        ],
      },
    };
  },
  mounted() {
    // console.log("Component moxxxunted.");
    // console.log("xxxx", $);
  },
  methods: {
    toggleWeekends: function () {
      this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
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
</style>
