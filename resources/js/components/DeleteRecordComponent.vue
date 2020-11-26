<template>
     <a  href="#" v-on:click.prevent="deleteRecord($event,title,message,'deleted', url)" 
        class="wt-deleteinfo" :id="id">
        <i class="lnr lnr-trash"></i>
    </a>
</template>
<script>
export default {
    props: ['title', 'message', 'id', 'url'],    
    components: {
        
    },
    data: function () {
        return {
           
        }
    },
    methods: {
        deleteRecord: function (event, delete_title, delete_message, deleted, date_url) {
                var element = event.currentTarget;
                this.elementID = element.getAttribute('id');
                this.$swal({
                    title: delete_title,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                  }).then((result) => {
                    var self = this;
                    if(result.value) {
                        var element_id = element.getAttribute('id');
                        axios.post(date_url, {
                            id: element_id
                        })
                        .then(function (response) {
                            jQuery('.del-' + element_id).remove();
                            self.$swal(deleted, delete_message, 'success')
                        })
                    } else {
                        this.$swal.close()
                    }
                  })
            },
    },
    mounted:function(){},
    created() {
        
    },
}
</script>