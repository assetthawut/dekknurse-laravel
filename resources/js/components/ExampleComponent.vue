<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">I'm an example component xxxx.</div>
          <button @click="toggleWeekends">toggle weekends</button>
          <FullCalendar :options="calendarOptions" />
        </div>
      </div>
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
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        weekends: false, // initial value
      },
    };
  },
  mounted() {
  },
  methods: {
    toggleWeekends: function () {
      this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
    },
  },
};
</script>
