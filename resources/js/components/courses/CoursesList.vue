<template>
<div>
    <div class="flex justify-between border-b-2 border-orange-500" >
        <div><h1 class="text-blue-500 mb-3 ml-4 text-xl p-1 ">
        Courses Catalog</h1></div>
        
        <div class="mt-2 "><a href="/courses/create" 
            class="shadow bg-blue-900 hover:bg-blue-800 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
            Add Course
        </a></div>
        
    </div>
    <div class="flex flex-wrap ml-6">
        <div v-for="course in courses" :key="course.name" class="w-2/5  mt-8 mr-8 max-w-sm rounded overflow-hidden shadow-lg">
            <img class="w-full" src="/images/card-top.jpg" alt="Sunset in the mountains">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">{{ course.name }}</div>
                <p class="text-gray-700 text-base">{{ course.description }}</p>
            </div>
            <div class="px-6 py-4">
                <span v-for="tag in course.tags" :key="tag.id" 
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                    #{{tag.name}}
                </span>                
            </div>
        </div>
    </div>
</div>
</template>

<script>

    export default {
        props: ['courses'],
        data: function () {
            return {
                
            }
        },
        methods: {
            onSubmit() {
                this.form.post('/courses')
                    .then(response => alert('created!'))
                    .catch(error => alert('failed'));
            }
        },        
        components: {
            
        },
        mounted() {
            console.log('Component mounted.');
            console.dir(this.courses.length);
        }
    }
</script>
