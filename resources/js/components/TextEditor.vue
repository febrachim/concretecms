<template>
  <vue-editor v-model="content" />
</template>

<script>
import { VueEditor } from "vue2-editor";

export default {
    components: { VueEditor },
    props: {
        content: {
            Type: String,
            required: true
        },
    },
    data: () => ({
        content: this.content
    }),
    watch: {
        content: function() {
            // Emit this information to the parents component
            this.$emit("content-changed", this.content);
        }
    }
};
</script>