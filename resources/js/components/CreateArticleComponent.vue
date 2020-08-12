<template>
  <b-form @submit.prevent="submit" method="post" enctype="multipart/form-data">
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
                  v-model="form.categories"
                  :options="options"
                  name="checkbox-categories"
                  stacked
                ></b-form-checkbox-group>
                <div class="text-danger" v-if="$v.form.categories.$error"><small>Please select at least 1 category</small></div>
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
                  :class="{ 'form-group--error': $v.form.title.$error }"
                >
                    <b-form-input type="text" name="title" id="input-title" size="lg" placeholder="" v-model="form.title"></b-form-input>
                    <slug-widget :url="url" subdirectory="article" :title="form.title" @slug-changed="updateSlug"></slug-widget>
                    <div class="text-danger" v-if="$v.form.title.$error"><small>Title is required</small></div>
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
                    <div class="text-danger" v-if="$v.form.excerpt.$error"><small>Excerpt is required</small></div>
                </b-form-group>

                <b-form-group
                  id="fieldset-content"
                  label="Content"
                  label-for="input-content"
                >
                    <vue-editor v-model="form.content" />
                    <div class="text-danger" v-if="$v.form.content.$error"><small>Content is required</small></div>
                </b-form-group>

                <b-form-group label="Banner Image" label-for="file-banner">
                    <b-form-file
                      v-model="form.fileBanner"
                      label="Banner Image"
                      :state="Boolean(form.fileBanner)"
                      placeholder="Choose a file or drop it here..."
                      drop-placeholder="Drop file here..."
                      name="banner"
                      accept="image/*"
                    ></b-form-file>
                    <div class="mt-0">
                        <small>
                            {{ form.fileBanner ? 'Selected file: '+form.fileBanner.name : 'No file selected' }}
                        </small>
                        <div class="text-danger" v-if="$v.form.fileBanner.$error"><small>Banner is required</small></div>
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
                      accept="image/*"
                    ></b-form-file>
                    <div class="mt-0">
                        <small>
                            {{ form.fileBannerMobile ? 'Selected file: '+form.fileBannerMobile.name : 'No file selected' }}
                        </small>
                        <div class="text-danger" v-if="$v.form.fileBannerMobile.$error"><small>Mobile Banner is required</small></div>
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
    import { required, minLength } from 'vuelidate/lib/validators';
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        components: {
            VueEditor
        },
        data: function() {
            return {
                success: false,
                errors: [],
                output: '',
                form: {
                    title: '',
                    slug: '',
                    categories: [],
                    excerpt: '',
                    content: '',
                    fileBanner: null,
                    fileBannerMobile: null,
                }
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
        validations: {
          form: {
                  title: {
                    required
                  },
                  slug: {
                    required
                  },
                  categories: {
                    required
                  },
                  excerpt: {
                    required
                  },
                  content: {
                    required
                  },
                  fileBanner: {
                    required
                  },
                  fileBannerMobile: {
                    required
                  },
                }
        },
        methods: {
          updateSlug: function(val) {
            this.form.slug = val;
          },
          submit(e) {

            const config = {
              headers: {
                'content-type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              }
            }

            let data = new FormData();

            data.append('api_token', this.token);
            data.append('title', this.form.title);
            data.append('slug', this.form.slug);
            data.append('categories', this.form.categories);
            data.append('excerpt', this.form.excerpt);
            data.append('content', this.form.content);
            data.append('fileBanner', this.form.fileBanner, this.form.fileBanner.name);
            data.append('fileBannerMobile', this.form.fileBannerMobile, this.form.fileBannerMobile.name);

            axios.post('/api/articles/store', data, config).then(response => {
              this.success = response.data.success;
              this.output = response.data;
              
              if(response.data.success == true) {
                this.errors = [];

                this.form = {
                  title: '',
                  slug: '',
                  categories: [],
                  excerpt: '',
                  content: '',
                  fileBanner: null,
                  fileBannerMobile: null,
                }
              }
            }).catch(error => {
              if (error.response.status == 422) {
                this.errors = error.response.data;

                this.output = error;

                console.log("ERRRR:: ",error.response.data);
              }
            })
          },

          error(field) {
            return _.head(field);
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
