<template>
  <div>
    <b-img-lazy v-bind="mainProps" :src="src" alt="Image 1"></b-img-lazy>
  </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },
    props: {
        src: {
            Type: String,
            required: true
        }
    },
    data: function() {
        return {
            mainProps: {
                center: true,
                fluidGrow: true,
                blank: true,
                blankColor: '#bbb',
                width: 600,
                height: 400,
                class: 'my-5'
            },
            src: ''
        }
    },
    methods: {
        getImageUrl(imageId) {
            const { width, height } = this.mainProps
            return `https://picsum.photos/${width}/${height}/?image=${imageId}`
        }
    }
}
</script>
