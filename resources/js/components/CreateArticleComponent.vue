<template>
  <ValidationObserver ref="form">
    <b-form ref="form" @submit.prevent="onSubmit" method="post" enctype="multipart/form-data">
      <input type="hidden" name="_token" class="form-control" :value="token">
      <div class="row">
          <div class="col-md-3 order-md-2">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>
              </div>
              <div class="card-body">
                <ValidationProvider name="categories" rules="required"" v-slot="{ valid, errors }">
                  <b-form-group
                  :state="errors[0] ? false : (valid ? true : null)">
                    <b-form-checkbox-group
                      id="checkbox-categories"
                      class="font-weight-normal"
                      v-model="form.categories"
                      :options="options"
                      name="checkbox-categories"
                      :state="errors[0] ? false : (valid ? true : null)"
                      stacked
                    ></b-form-checkbox-group>
                  </b-form-group>
                  <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                </ValidationProvider>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <ValidationProvider rules="required" name="Title" v-slot="{ valid, errors }">
                  <b-form-group
                    id="fieldset-title"
                    label="Title"
                    label-for="input-title"
                    :state="errors[0] ? false : (valid ? true : null)"
                  >
                    <b-form-input type="text" name="title" id="input-title" size="lg" placeholder="" v-model="form.title" :state="errors[0] ? false : (valid ? true : null)" ref="title"></b-form-input>
                    <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    <slug-widget ref="slug" name="Slug" :url="url" subdirectory="article" :title="form.title" :state="errors[0] ? false : true" @slug-changed="updateSlug"></slug-widget>
                  </b-form-group>
                </ValidationProvider>

                <ValidationProvider rules="required" name="Excerpt" v-slot="{ valid, errors }">
                  <b-form-group
                    id="fieldset-excerpt"
                    label="Excerpt"
                    label-for="input-excerpt"
                    :state="errors[0] ? false : (valid ? true : null)"
                  >
                    <b-form-textarea
                      id="input-excerpt"
                      v-model="form.excerpt"
                      placeholder=""
                      rows="4"
                      max-rows="6"
                      name="excerpt"
                      :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-textarea>
                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>

                <ValidationProvider name="Content" rules="required" v-slot="{ valid, errors }">
                  <b-form-group
                    id="fieldset-content"
                    label="Content"
                    label-for="input-content"
                    :state="errors[0] ? false : (valid ? true : null)"
                  >
                    <!-- <vue-editor data-vv-name="Content" v-model="form.content"/> -->
                    <quill-editor v-model="form.content"
                      class="form-content mb-3"
                      :options="editorOption"
                      ref="myQuillEditor"
                      @blur="onEditorBlur($event)"
                      @focus="onEditorFocus($event)"
                      @ready="onEditorReady($event)"
                      data-vv-name="Content">
                    </quill-editor>
                  </b-form-group>
                  <b-form-invalid-feedback id="inputLiveFeedback" class="mb-4">{{ errors[0] }}</b-form-invalid-feedback>
                </ValidationProvider>

                <ValidationProvider name="Banner Image" rules="required|image" v-slot="{ valid, errors }">
                  <b-form-group label="Banner Image" label-for="file-banner">
                      <b-form-file
                        v-model="form.fileBanner"
                        label="Banner Image"
                        :state="errors[0] ? false : (valid ? true : null)"
                        placeholder="Choose a file or drop it here..."
                        drop-placeholder="Drop file here..."
                        name="banner"
                        accept="image/*"
                      ></b-form-file>
                      <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                      <div class="mt-0">
                          <small>
                              {{ form.fileBanner ? 'Selected file: '+form.fileBanner.name : 'No file selected' }}
                          </small>
                      </div>
                  </b-form-group>
                </ValidationProvider>

                <ValidationProvider name="Mobile Banner Image" rules="required|image" v-slot="{ valid, errors }">
                  <b-form-group label="Mobile Banner Image" label-for="file-banner">
                      <b-form-file
                        v-model="form.fileBannerMobile"
                        label="Mobile Banner Image"
                        :state="errors[0] ? false : (valid ? true : null)"
                        placeholder="Choose a file or drop it here..."
                        drop-placeholder="Drop file here..."
                        name="banner_mobile"
                        accept="image/*"
                      ></b-form-file>
                      <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                      <div class="mt-0">
                          <small>
                              {{ form.fileBannerMobile ? 'Selected file: '+form.fileBannerMobile.name : 'No file selected' }}
                          </small>
                      </div>
                  </b-form-group>
                </ValidationProvider>

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
  </ValidationObserver>
</template>

<script>
  import 'quill/dist/quill.core.css'
  import 'quill/dist/quill.snow.css'
  import 'quill/dist/quill.bubble.css'

  import { quillEditor, Quill } from 'vue-quill-editor'

  // Set toolbar options
  const toolbarOptions = [
      [{'header': [1, 2, 3, 4, 5, 6, false]}],
      [{'align': []}],
      ['bold', 'italic', 'underline', 'strike'],
      ['blockquote', 'code-block'],

      [{'header': 1}, {'header': 2}],
      [{'list': 'ordered'}, {'list': 'bullet'}],
      [{'script': 'sub'}, {'script': 'super'}],
      [{'indent': '-1'}, {'indent': '+1'}],

      // [{'size': ['small', false, 'large', 'huge']}],

      [{'color': []}, {'background': []}],
      // [{'font': []}],
      ['link', 'image', 'video'],
      ['clean'],
  ];

  export default {
      components: {
          // VueEditor,
          quillEditor
      },
      data: function() {
          return {
              success: false,
              submitStatus: null,
              value: '',
              form: {
                  title: '',
                  slug: '',
                  categories: [],
                  excerpt: '',
                  content: '',
                  fileBanner: null,
                  fileBannerMobile: null,
              },
              editorOption: {
                theme: 'snow',
                modules: {
                    toolbar: {
                        container: toolbarOptions,
                    },
                    history: {
                        delay: 1000,
                        maxStack: 50,
                        userOnly: false
                    }
                }
              },
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
          },
          status: {
            type: String,
          },
          blank: {
            type: String
          }
      },
      methods: {
        updateSlug: function(val) {
          this.form.slug = val;
        },
        onEditorBlur(editor) {
            // console.log('editor blur!', editor)
        },
        onEditorFocus(editor) {
            // console.log('editor focus!', editor)
        },
        onEditorReady(editor) {
            // console.log('editor ready!', editor)
        },
        onSubmit(e) {
          this.$refs.form.validate().then(success => {
            if (!success) {
              const errors = Object.entries(this.$refs.form.refs)
              .map(([key, value]) => ({
                key,
                value
              }))
              .filter(error => {
                if (!error || !error.value || !error.value.failedRules) return false;
                return Object.keys(error.value.failedRules).length > 0;
              });
              if (errors && errors.length > 0) {
                this.$refs.form.refs[errors[0]['key']].$el.scrollIntoView({
                  behavior: 'smooth',
                  block: 'center'
                });
              }
              return false;
            } else {
            // SUCCESS
            console.log('submitted');
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
              console.log("COBA WOI");
              console.log(this.success);
                
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

                this.$refs.slug._data.slug = '';
                this.$refs.form.reset();
              }
            }).catch(error => {
              console.log(error.message);
              if (error.response.status == 422) {
                this.errors = error.response.data;
              }
            })

            this.submitStatus = 'PENDING'
            setTimeout(() => {
              this.submitStatus = 'OK'
            }, 500)
            }
          });
        },

        error(field) {
          return _.head(field);
        }
      },
      computed: {
          editor(){
              return this.$refs.myQuillEditor.quill
          }
      },
  }
</script>
<style lang="css" scope>
    /*@import "~vue2-editor/dist/vue2-editor.css";*/

    /* Import the Quill styles you want */
    /*@import '~quill/dist/quill.core.css';*/
    /*@import '~quill/dist/quill.bubble.css';*/
    /*@import '~quill/dist/quill.snow.css';*/


    .font-weight-normal label {
      font-weight: 400 !important;
    }

    #fieldset-content.is-invalid .quillWrapper {
      border: 1px solid #dc3545 !important;
    }

    .form-content .ql-editor {
      height: 250px;
    }
</style>
