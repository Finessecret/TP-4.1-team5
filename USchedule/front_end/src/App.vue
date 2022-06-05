<template>
  <NavBar></NavBar>
  <router-view />
</template>

<script>
import NavBar from './components/NavBar'
export default {
  name: 'AppComponent',
  components: {
    NavBar
  }
}
</script>
