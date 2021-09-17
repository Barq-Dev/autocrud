<template lang="">
    <v-menu
        ref="menu1"
        v-model="menu1"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        max-width="290px"
        max-height="290px"
        >
        <template v-slot:activator="{ on, attrs }">
            <v-text-field
            v-model="dateFormatted"
            label="Date"
            hint="DD/MM/YYYY format"
            persistent-hint
            v-bind="attrs"
            
            v-on="on"
            ></v-text-field>
        </template>
        <v-date-picker
            v-model="date"
            no-title
            @input="menu1 = false"
        ></v-date-picker>
          </v-menu>
</template>
<script>
export default {
    props:['form'],
    data: (vm) => ({
            date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      .toISOString()
      .substr(0, 10),
    dateFormatted: vm.formatDate(
      new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10)
    ),
    menu1: false,
        }),

    computed: {
    computedDateFormatted() {
      return this.formatDate(this.date);
    },
  },

  watch: {
    date() {
      this.dateFormatted = this.formatDate(this.date);
      this.form.date = this.date
    }
  },

  methods: {
    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    parseDate(date) {
      if (!date) return null;

      const [month, day, year] = date.split("/");
      return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    },
  },
    
}
</script>
<style lang="">
    
</style>