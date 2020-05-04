<template>
    <div>
        <multiselect v-model="value" 
            tag-placeholder="Add this as new tag" 
            placeholder="Search or add a tag" label="name" 
            track-by="id" 
            :options="options" 
            :multiple="true" 
            :taggable="true" 
            @tag="addTag"
            @input="$emit('recordTags',value)"></multiselect>
        <!--<pre class="language-json"><code>{{ value  }}</code></pre>-->
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import Multiselect from 'vue-multiselect'

export default {    
    props: ['tagOptions', 'tagsSelected'],
    components: {
        Multiselect
    },
    data () {
        return {
            value: this.tagsSelected,
            options: this.tagOptions
        }
    },
    methods: {
        addTag (newTag) {
            const tag = {
                name: newTag,
                id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(tag)
            this.value.push(tag)
            this.$emit('recordTags', this.value);
        },
        /*onTagsChange($event){            
            this.$emit('recordTags', this.value);
        },*/
    },
    mounted() {
        //console.log('Tags component mounted.')            
        //console.log(this.tagOptions);
        
    }
}
</script>