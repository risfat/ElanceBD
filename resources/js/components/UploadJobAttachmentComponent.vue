<template>
  <div class="multile-file-attachments wt-haslayout">
    <vue-dropzone :options="this.dropzoneOptions" id="upload" ref="success_ref" :useCustomSlot=true>
        <div class="form-group form-group-label">
            <div class="wt-labelgroup">
                <label for="file">
                    <span class="wt-btn">{{ trans('lang.select_files') }}</span>
                </label>
                <span>{{ trans('lang.drop_files') }}</span>
            </div>
        </div>
    </vue-dropzone>
  </div>
</template>

<script>
const getTemplate = () => `
  <li>
      <span><span data-dz-name></span></span> 
      <em>File size: <span data-dz-size></span>
          <a class="image_upload_anchor">
              <span class="lnr lnr-cross"></span>
          </a>
      </em>
  </li>`;
import vueDropzone from "vue2-dropzone";
import 'vue2-dropzone/dist/vue2Dropzone.css'
export default {
    props: ['temp_url', 'img_ref'],
 data () {
    return {
      dropzoneOptions: {
          url: this.getUrl(),
          maxFiles: 20,
          addRemoveLinks: false,
          previewTemplate: getTemplate(),
          previewsContainer: '.dropzone-previews',
          headers: {
              'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
          },
          init: function() {
              var count = 0;
              var myDropzone = this;
              this.on("addedfile", function(file) { 
                var li_count = jQuery('.wt-attachmentsholder').find('.lara-attachment-files .form-group ul li').length;
                count = li_count -1;
                jQuery('#'+myDropzone.element.id).parents('.wt-attachmentsholder').find('.lara-attachment-files .input-preview ul.dropzone-previews').append('<input type="hidden" value="'+file.name+'" class="hidden-file" name="attachments['+[count]+']">');
                count++
              });
              this.on("removedfile", function(file) { });
          }
      },
    }
  },
  methods:{
    getUrl() {
        return this.temp_url;
    }
  },
  mounted: function () {
    jQuery(document).on('click', '.image_upload_anchor', function(e){
      e.preventDefault();
      var _this = jQuery(this);
      _this.parents('li').next('input[type=hidden]').remove();
      _this.parents('li').remove();
    })
  },
  components: {
    vueDropzone
  }
};
</script>