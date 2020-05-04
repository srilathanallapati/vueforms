<template>
   <div class="flex">
        <input class="border border-gray-400 p-2 mr-2" 
            type="file" id="image" ref="file" v-on:change="handleFileUpload()"/>
        <img v-if="image" :src="selectedImage" >    
        <!--<button class="btn btn-success btn-block" v-on:click="upload()">Upload</button>-->                
    </div>
</template>
<style scoped>
    img{
        max-height: 80px;
    }
</style>
<script>
    export default{
        //props: ['selectedImage'],
        data(){
            return {
                image: '',
                selectedImage: ''
            }
        },
        methods: {
            handleFileUpload($event){                
                this.image = this.$refs.file.files[0];                
                this.createImage(this.image);
                this.$emit('receiveImage', this.image);
            },
            createImage(image) {
                let reader = new FileReader();                
                reader.onload = (e) => {
                    this.selectedImage = e.target.result;
                };
                reader.readAsDataURL(image);
            },
            /*upload(){                
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();                
                formData.append('file', this.image);
                axios.post('/courses/fileupload',formData, config).then(response => {
                    console.log(response);
                })
                .catch(function(){
                    console.log('FAILURE!!');
                });
            }*/
        },
        mounted() {
            console.log('Image upload component mounted.')
        }
    }
</script>