<template>
  <v-file-input
    v-model="form.file"
    @change="tes"
    color="deep-purple accent-4"
    counter
    :label="label"
    placeholder="Select your file"
    prepend-icon="mdi-paperclip"
    outlined
    :show-size="1000"
  >
    <template v-slot:selection="{ index, text }">
      <v-chip
        v-if="index < 2"
        color="deep-purple accent-4"
        dark
        label
        small
      >
        {{ text }}
      </v-chip>

      <span
        v-else-if="index === 2"
        class="text-overline grey--text text--darken-3 mx-2"
      >
        +{{ file.length - 2 }} File(s)
      </span>
    </template>
  </v-file-input>
</template>

<script>
  export default {
    props:['form','label'],
    data: () => ({
      file: null,
    })
  }
</script>