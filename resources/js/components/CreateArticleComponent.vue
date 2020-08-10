<template>
<b-form @submit="onSubmit" @reset="onReset">
    <input type="hidden" name="_token" class="form-control" :value="token">
<div class="row">
    <div class="col-md-3 order-md-2">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Categories</h3>
        </div>
        <div class="card-body">
            <b-form-checkbox-group
              id="checkbox-categories"
              class="font-weight-normal"
              v-model="form.selected"
              :options="options"
              name="checkbox-categories"
              stacked
            ></b-form-checkbox-group>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <!-- /.col -->
    <div class="col-md-9">
      <div class="card card-primary card-outline">
        <div class="card-body">
            <b-form-group
              id="fieldset-title"
              label="Title"
              label-for="input-title"
            >
                <b-form-input type="text" name="title" id="input-title" size="lg" placeholder="" v-model="form.title"></b-form-input>
                <slug-widget :url="url" subdirectory="article" :title="form.title" @slug-changed="updateSlug"></slug-widget>
            </b-form-group>

            <b-form-group
              id="fieldset-excerpt"
              label="Excerpt"
              label-for="input-excerpt"
            >
                <b-form-textarea
                  id="input-excerpt"
                  v-model="form.excerpt"
                  placeholder=""
                  rows="4"
                  max-rows="6"
                  name="excerpt"
                ></b-form-textarea>
            </b-form-group>

            <b-form-group
              id="fieldset-content"
              label="Content"
              label-for="input-content"
            >
                <vue-editor v-model="form.content" />
            </b-form-group>

            <b-form-group label="Banner Image" label-for="file-banner">
                <b-form-file
                  v-model="form.fileBanner"
                  label="Banner Image"
                  :state="Boolean(form.fileBanner)"
                  placeholder="Choose a file or drop it here..."
                  drop-placeholder="Drop file here..."
                  name="banner"
                ></b-form-file>
                <div class="mt-0">
                    <small>
                        {{ form.fileBanner ? 'Selected file: '+form.fileBanner.name : 'No file selected' }}
                    </small>
                </div>
            </b-form-group>

            <b-form-group label="Mobile Banner Image" label-for="file-banner">
                <b-form-file
                  v-model="form.fileBannerMobile"
                  label="Mobile Banner Image"
                  :state="Boolean(form.fileBannerMobile)"
                  placeholder="Choose a file or drop it here..."
                  drop-placeholder="Drop file here..."
                  name="banner_mobile"
                ></b-form-file>
                <div class="mt-0">
                    <small>
                        {{ form.fileBannerMobile ? 'Selected file: '+form.fileBannerMobile.name : 'No file selected' }}
                    </small>
                </div>
            </b-form-group>

            <div>
                <b-button variant="primary" type="submit">Submit</b-button>
            </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
</b-form>
</template>

<script>
    import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js";
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        components: {
            VueEditor
        },
        data: function() {
            return {
                form: {
                    token: this.token,
                    title: '',
                    slug: '',
                    selected: [],
                    excerpt: '',
                    content: '',
                    fileBanner: null,
                    fileBannerMobile: null,
                },
                token: '',
                title: '',
                slug: '',
                selected: [],
                excerpt: '',
                fileBanner: null,
                fileBannerMobile: null,
                content: '',
            } 
        },
        props: {
            options: {
                Type: Array,
                required: true
            },
            url: {
                Type: String,
                required: true
            },
            token: {
                Type: String,
                required: true
            }
        },
        methods: {
          updateSlug: function(val) {
            this.form.slug = val;
          },
          onSubmit(evt) {
            evt.preventDefault()
            alert(JSON.stringify(this.form))
          },
          onReset(evt) {
            evt.preventDefault()
            // Reset our form values
            this.form.title = ''
            this.form.slug = ''
            this.form.selected = []
            this.form.excerpt = ''
            this.form.content = ''
            this.form.fileBanner = null
            this.form.fileBannerMobile = null
          }
        }
    }
</script>
<style lang="css" scope>
    @import "~vue2-editor/dist/vue2-editor.css";

    /* Import the Quill styles you want */
    /*@import '~quill/dist/quill.core.css';*/
    /*@import '~quill/dist/quill.bubble.css';*/
    @import '~quill/dist/quill.snow.css';

    .font-weight-normal label {
        font-weight: 400 !important;
    }
</style>
