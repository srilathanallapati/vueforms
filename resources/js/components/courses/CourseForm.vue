<template>
    <div class="ml-8">         
        <div>
            <h1 v-show="!editMode" class="text-blue-500 mb-3 text-xl p-1 border-b-2 border-orange-500">Create Course</h1>
            <h1 v-show="editMode" class="text-blue-500 mb-3 text-xl p-1 border-b-2 border-orange-500">Edit Course</h1>
        </div>
        <div class="w-2/3">
            <form @submit.prevent="editMode ? onEditSubmit() : onSubmit()" 
                @keydown="form.errors.clear($event.target.name)" enctype="multipart/form-data">
                <div class="mb-6 mt-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700">
                        Course Name:
                    </label>
                    <input type="text" id="name" name="name" class="form-input"
                    v-model="form.name" size="78"/>
                    <div class="text-red-500 text-xs italic" v-if="form.errors.has('name')" 
                    v-text="form.errors.get('name')"></div>                
                </div>
                <div class="mb-6">    
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700">
                        Course Description:
                    </label>
                    <textarea id="description" name="description" class="form-textarea" 
                        cols="80" rows="3" v-model="form.description" ></textarea>
                    <div class="text-red-500 text-xs italic" v-if="form.errors.has('description')" 
                    v-text="form.errors.get('description')"></div>            
                </div>
                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" 
                    for="image">
                        Catalog Image
                    </label>
                    <ImageUpload v-on:receiveImage="onImageUpload" 
                        :courseImage="courseImage"></ImageUpload>
                    <div class="text-red-500 text-xs italic" v-if="form.errors.has('catalog_image')" 
                    v-text="form.errors.get('catalog_image')"></div>            
                </div>
                <div class="mb-12">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700">
                        Tags:
                    </label>                
                    <Tags :tag-options="tagOptions" :tagsSelected="parseJSONTags" v-on:recordTags="onRecordTags"></Tags>
                    <div class="text-red-500 text-xs italic" v-if="form.errors.has('tags')" 
                        v-text="form.errors.get('tags')"></div>
                </div>
                <div>
                    <button v-show="!editMode" class="shadow bg-blue-900 hover:bg-blue-800 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" 
                     :disabled="form.errors.any()">Create</button>
                     <button v-show="editMode" class="shadow bg-blue-900 hover:bg-blue-800 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" 
                     >Update</button>                     
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Form from '../../core/Form';
    import Tags from '../core/Tags.vue';
    import ImageUpload from '../core/ImageUpload.vue';

    export default {
        props: ['tagOptions','course'],
        data: function () {
            return {   
                editMode: false, 
                courseImage: '',        
                form: new Form({
                    id: '',
                    name: '',
                    description: '',                    
                    tags: [],
                    catalog_image: '',
                })
            }
        },
        computed: {
            parseJSONTags: function () {                
                return (this.form.tags.length > 0)? JSON.parse(this.form.tags):[];
            }
        },
        methods: {
            onSubmit() {               
                this.form.postDataWithFileHeaders('/courses')
                    .then(response => window.location.href = '/courses')
                    .catch(error => alert('failed'));
            },
            onEditSubmit() {                
                this.form.putDataWithFileHeaders('/courses/'+this.form.id)
                    .then(response => window.location.href = '/courses')
                    .catch(error => alert('failed'));
            },
            onImageUpload: function (image){
                this.form.catalog_image = image;
            },
            onRecordTags: function (tags) {                
                this.form.tags = JSON.stringify(tags);
            }
        },        
        components: {
            Form,
            Tags,
            ImageUpload
        },
        created() {            
            //console.log(this.course); 
            if(this.course){
                this.editMode = true;
                this.form.id = this.course.id;           
                this.form.name = this.course.name;
                this.form.description = this.course.description;
                this.form.tags = JSON.stringify(this.course.tags);
                this.courseImage = this.course.catalog_image;                 
            }
        }
    }
</script>
