export default {
  props: {
    layout: {
      type: String
    }
  },
  data() {
    return {
      layoutName: 'default'
    }
  },
  created() {
    this.$emit('update:layout', this.returnLayout)
  },
  computed: {
    returnLayout() {
      return `${this.layoutName[0].toUpperCase()}${this.layoutName.slice(1)}Layout`
    }
  }
}