<template>
  <TheHeaderLoggedIn v-if="$page.props.auth.user" />
  <TheHeaderPublic v-else />
</template>

<script>
import TheHeaderLoggedIn from "@/Components/TheHeaderLoggedIn";
import TheHeaderPublic from "@/Components/TheHeaderPublic";
export default {
  components: {
    TheHeaderLoggedIn,
    TheHeaderPublic,
  },
};
</script>