@extends('backoffice::layouts.master')

@section('cssfile')
<!-- Styles -->
<style>
    .error {
        color:red;
        font-weight: 400 !important;
    } 
</style>
@endsection

@section('jsfile')
@endsection

@section('content')
{{-- {{ dd($checkbox_categories) }} --}}
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 id="title-create-article" class="m-0 text-dark">{!! config('article.name.create') !!}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Starter Page</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        {{ Form::model($article, [
            'route' => [
                'admin.article.update',
                $article->id
                ],
            'method' => 'patch',
            'files' => true,
        ]) }} 
        
        <div class="alert alert-success d-none" id="msg_div">
            <span id="res_message"></span>
        </div>
        
        {!! csrf_field() !!}
        
        <div class="row">
            <div class="col-md-3 order-md-2">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Categories</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            @for ($i = 0; $i < count($checkbox_categories); $i++)
                            <div class="form-check">
                                {!! Form::checkbox('categories[]', $checkbox_categories[$i]['value'], null, ['id' => 'category-'.$i, 'class' => 'form-check-input']) !!}
                                {!! Form::label('category-'.$i, $checkbox_categories[$i]['text'], ['class' => 'font-weight-normal']) !!}
                            </div>
                            @endfor
                            <div id="categories-error"></div>
                            <span class="text-danger">{{ $errors->first('categories') }}</span>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <b-form-group id="fieldset-title" label="Title" label-for="input-title">
                            <b-form-input type="text" name="title" id="input-title" size="lg" placeholder="" v-model="form.title" ref="title" autocomplete="off"></b-form-input>
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </b-form-group>
                        
                        <b-form-group id="fieldset-slug" label="Slug" label-for="input-slug">
                            <b-form-input type="text" name="slug" id="input-slug" placeholder="" v-model="form.slug" ref="slug" @change="onSlugChange($event)" autocomplete="off"></b-form-input>
                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                        </b-form-group>
                        
                        <b-form-group id="fieldset-excerpt" label="Excerpt" label-for="input-excerpt">
                            <b-form-textarea
                            id="input-excerpt"
                            v-model="form.excerpt"
                            placeholder=""
                            rows="4"
                            max-rows="6"
                            name="excerpt"
                            ></b-form-textarea>
                            <span class="text-danger">{{ $errors->first('excerpt') }}</span>
                        </b-form-group>
                        
                        <b-form-group id="fieldset-content" label="Content" label-for="input-content" class="mb-0">
                            <vue-editor v-model="form.content" />
                        </b-form-group>
                        
                        <b-form-group class="mt-0">
                            <input name="content" type="hidden" :value="form.content" id="form-content">
                            <span class="text-danger">{{ $errors->first('content') }}</span>
                        </b-form-group> 
                        
                        <b-form-group label="Banner Image" label-for="file-banner">
                            <div id="default-banner" class="mb-2" v-if="!bannerUrl">
                                <b-img-lazy src="{!! $article->getFirstMediaUrl('article-banner', 'display') !!}" fluid-grow alt="Banner"></b-img-lazy>
                            </div>
                            <div id="preview-banner" class="mb-2" v-if="bannerUrl">
                                <b-img-lazy :src="bannerUrl" fluid-grow alt="Banner" /></b-img-lazy>
                                <b-button @click="clearBanner" class="mt-2">Reset Banner Image</b-button>
                            </div>
                            <b-form-file
                            v-model="form.fileBanner"
                            label="Banner Image"
                            placeholder="Change banner image..."
                            drop-placeholder="Drop file here..."
                            name="fileBanner"
                            accept="image/jpeg, image/png"
                            ref="file-banner"
                            @change="onBannerChange"
                            ></b-form-file>
                        </b-form-group>
                        
                        <b-form-group label="Mobile Banner Image" label-for="file-banner">
                            <div id="default-banner" class="mb-2" v-if="!bannerMobileUrl">
                                <b-img-lazy src="{!! $article->getFirstMediaUrl('article-mobile-banner', 'display') !!}" fluid-grow alt="Mobile Banner" class="mb-2"></b-img-lazy>
                            </div>
                            <div id="preview-banner" class="mb-2" v-if="bannerMobileUrl">
                                <b-img-lazy :src="bannerMobileUrl" fluid-grow alt="Mobile Banner" /></b-img-lazy>
                                <b-button @click="clearMobileBanner" class="mt-2">Reset Mobile Banner Image</b-button>
                            </div>
                            
                            <b-form-file
                            v-model="form.fileBannerMobile"
                            label="Mobile Banner Image"
                            placeholder="Change mobile banner image..."
                            drop-placeholder="Drop file here..."
                            name="fileBannerMobile"
                            accept="image/jpeg, image/png"
                            ref="file-mobile-banner"
                            @change="onMobileBannerChange"
                            ></b-form-file>
                        </b-form-group>
                        
                        <b-form-group>
                            <b-button type="submit" id="btn-submit" variant="primary">Submit</b-button>
                        </b-form-group>
                        
                    </div>
                </div>
            </div>
        </div>
        
        {{ Form::close() }}
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
<script>
    const vue = new Vue({
        el: '#app',
        data: {
            form: {
                title: '{!! isset($article) ? $article->title : '' !!}',
                slug: Slug('{!! isset($article) ? $article->slug : '' !!}'),
                categories: [],
                excerpt: '{!! isset($article) ? $article->excerpt : '' !!}',
                content: '{!! isset($article) ? $article->content : '' !!}',
                fileBanner: null,
                fileBannerMobile: null,
            },
            api_token: '{{ Auth::user()->api_token }}',
            selected: [],
            options: {!! json_encode($checkbox_categories,TRUE) !!},
            url: '{{ url('/') }}',
            blank: '',
            bannerUrl: null,
            bannerMobileUrl: null,
        },
        methods: {
            onBannerChange(e) {
                const file = e.target.files[0];
                this.bannerUrl = URL.createObjectURL(file);
            },
            onMobileBannerChange(e) {
                const file = e.target.files[0];
                this.bannerMobileUrl = URL.createObjectURL(file);
            },
            clearBanner() {
                this.$refs['file-banner'].reset();
                this.bannerUrl = null;
            },
            clearMobileBanner() {
                this.$refs['file-mobile-banner'].reset();
                this.bannerMobileUrl = null;
            },
            onSlugChange(e) {
                this.form.slug = Slug(e);
            }
        },
    });
</script>
@endsection