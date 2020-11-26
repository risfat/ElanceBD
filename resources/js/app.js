/**
 * Load all the javascript by using Vue.js and write all your JS code
 * in this file.
 */

require('./bootstrap');
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import '../../public/js/chosen.jquery.js';
//import 'vue2-dropzone/dist/vue2Dropzone.css'
import 'vue-date-pick/dist/vueDatePick.css';
import '../../public/js/emojionearea.min.js';
import '../../public/css/emojionearea.min.css';
import '../../public/css/basictable.css';
import datePicker from 'vue-bootstrap-datetimepicker';
import '../../public/js/tinymce/tinymce.min.js';
import '../../public/js/appear.js';
import '../../public/js/owl.carousel.min.js';
import '../../public/js/jquery.basictable.min.js';
// import 'bootstrap/dist/css/bootstrap.css';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.css';
import SmoothScrollbar from 'vue-smooth-scrollbar';
import VueSweetalert2 from 'vue-sweetalert2';
import { VueStars } from "vue-stars";
import { Printd } from "printd";
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';
import Vuebar from 'vuebar';
import Event from './event.js';
import * as VueGoogleMaps from 'vue2-google-maps'
import Verte from 'verte';
import 'verte/dist/verte.css';

Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};

Vue.filter('two_digits', function (value) {
    if(value.toString().length <= 1)
    {
        return "0"+value.toString();
    }
    return value.toString();
});

Vue.use(VueGoogleMaps, {
    load: {
      key: Map_key,
      libraries: 'places',
    },
})
Vue.use(VueIziToast);
Vue.use(SmoothScrollbar)
Vue.use(VueSweetalert2);
Vue.use(Vuebar);

window.Vue = require('vue');
window.flashVue = new Vue();
window.deleteVue = new Vue();
window.flashMessageVue = new Vue();

Vue.use(datePicker);
Vue.use(BootstrapVue);

Vue.component('verte', Verte);
Vue.component('upload-file', require('./components/UploadFileComponent.vue').default);
Vue.component('upload-image', require('./components/UploadImageComponent.vue').default);
Vue.component('flash_messages', require('./components/FlashMessages.vue').default);
Vue.component('switch_button', require('./components/SwitchButton.vue').default);
Vue.component('user_skills', require('./components/ProfileSkillComponent.vue').default);
Vue.component('freelancer_experience', require('./components/ProfileExperienceComponent.vue').default);
Vue.component('freelancer_education', require('./components/ProfileEducationComponent.vue').default);
Vue.component('freelancer_project', require('./components/ProfileProjectComponent.vue').default);
Vue.component('freelancer_award', require('./components/ProfileAwardComponent.vue').default);
Vue.component('job_attachments', require('./components/UploadJobAttachmentComponent.vue').default);
Vue.component('job_multiple-attachments', require('./components/JobMultipleAttachmentComponent.vue').default);
Vue.component('job_skills', require('./components/JobSkillComponent.vue').default);
Vue.component('private-message', require('./components/PrivateMessageComponent.vue').default);
Vue.component('rating', require('./components/RatingComponent.vue').default);
Vue.component('search-form', require('./components/SearchComponent.vue').default);
require('./components/FlashMessageComponent.vue').default
Vue.component("vue-stars", VueStars)
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead)
Vue.component('chat', require('./components/Chat.vue').default);
Vue.component('chat-users', require('./components/ChatUserComponent.vue').default);
Vue.component('chat-messages', require('./components/ChatMessageComponent.vue').default);
Vue.component('chat-area', require('./components/ChatAreaComponent.vue').default);
Vue.component('message-center', require('./components/ChatComponent.vue').default);
Vue.component('emoji-textarea', require('./components/emojiTexeareaComponent.vue').default);
Vue.component('delete', require('./components/DeleteRecordComponent.vue').default);
Vue.component('countdown', require('./components/CountdownComponent.vue').default);
Vue.component('experience', require('./components/FreelancerExperienceComponent.vue').default);
Vue.component('education', require('./components/FreelancerEducationComponent.vue').default);
Vue.component('crafted_project', require('./components/FreelancerCraftedProjetcsComponent.vue').default);
Vue.component('custom-map', require('./components/map.vue').default);

jQuery(document).ready(function () {
    jQuery(document).on('click', '.wt-back', function (e) {
        e.preventDefault();
         jQuery('.wt-back').parents('.wt-messages-holder').removeClass('wt-openmsg');
    });

    jQuery(document).on('click', '.wt-ad', function (e) {
        e.preventDefault();
        jQuery('.wt-ad').parents('.wt-messages-holder').addClass('wt-openmsg');
    });
    jQuery('.wt-navigation ul li.menu-item-has-children, .wt-navdashboard ul li.menu-item-has-children').prepend('<span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>');
    jQuery('.wt-navigation ul li.menu-item-has-children span').on('click', function() {
        jQuery(this).parent('li').toggleClass('wt-open');
        jQuery(this).next().next().slideToggle(300);
    });

    jQuery('.wt-navigation ul li.menu-item-has-children > a, .wt-navigation ul li.page_item_has_children > a').on('click', function() {
        if ( location.href.indexOf("#") != -1 ) {
            jQuery(this).parent('li').toggleClass('wt-open');
            jQuery(this).next().slideToggle(300);
        } else{
            //do nothing
        }
        
    });
    
    jQuery('.wt-navdashboard ul li.menu-item-has-children').on('click', function(){
        jQuery(this).toggleClass('wt-open');
        jQuery(this).find('.sub-menu').slideToggle(300);
    });
    

    function fixedNav(){
		$(window).scroll(function () {
		var $pscroll = $(window).scrollTop();
			if($pscroll > 76){
			 $('.wt-sidebarwrapper').addClass('wt-fixednav');
			}else{
			 $('.wt-sidebarwrapper').removeClass('wt-fixednav');
			}
		});
	}
	fixedNav();

    var _readmore = jQuery('.wt-userdetails .wt-description');
   _readmore.readmore({
		speed: 500,
		collapsedHeight: 230,
		moreLink: '<a class="wt-btntext" href="#">Read More</a>',
		lessLink: '<a class="wt-btntext" href="#">Less</a>',
    });

    jQuery('.filter-records').on('keyup', function(){
        var content = jQuery(this).val();
        console.log(content);
		jQuery(this).parents('fieldset').siblings('fieldset').find('.wt-checkbox:contains(' + content + ')').show();
		jQuery(this).parents('fieldset').siblings('fieldset').find('.wt-checkbox:not(:contains(' + content + '))').hide();
    });

    jQuery('#wt-btnclosechat, #wt-getsupport').on('click', function(){
		jQuery('.wt-chatbox').slideToggle();
    });

    if(jQuery('.wt-verticalscrollbar').length > 0){
		var _wt_verticalscrollbar = jQuery('.wt-verticalscrollbar');
		_wt_verticalscrollbar.mCustomScrollbar({
			axis:"y",
		});
    }

	jQuery("#wt-categoriesslider").owlCarousel({
		item: 6,
		loop:true,
		nav:false,
		margin: 0,
		autoplay:false,
		center: true,
		responsiveClass:true,
		responsive:{
			0:{items:1,},
			481:{items:2,},
			768:{items:3,},
			1440:{items:4,},
			1760:{items:6,}
		}
    });
    /* BANNER VIDEO */
	jQuery("a[data-rel]").each(function () {
		jQuery(this).attr("rel", jQuery(this).data("rel"));
	});
	jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
		animation_speed: 'normal',
		theme: 'dark_square',
		slideshow: 3000,
		autoplay_slideshow: false,
		social_tools: false
    });

    var popupMeta = {
        width: 400,
        height: 400
    }
    $(document).on('click', '.social-share', function(event){
        event.preventDefault();

        var vPosition = Math.floor(($(window).width() - popupMeta.width) / 2),
            hPosition = Math.floor(($(window).height() - popupMeta.height) / 2);

        var url = $(this).attr('href');
        var popup = window.open(url, 'Social Share',
            'width='+popupMeta.width+',height='+popupMeta.height+
            ',left='+vPosition+',top='+hPosition+
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            return false;
        }
    });

    jQuery('#wt-loginbtn, .wt-loginheader a').on('click', function(event) {
        event.preventDefault();
        jQuery('.wt-loginarea .wt-loginformhold').slideToggle();
    });

    if(jQuery('#wt-btnmenutoggle').length > 0){
		jQuery("#wt-btnmenutoggle").on('click', function(event) {
			event.preventDefault();
			jQuery('#wt-wrapper').toggleClass('wt-openmenu');
			jQuery('body').toggleClass('wt-noscroll');
			jQuery('.wt-navdashboard ul.sub-menu').hide();
		});
    }

    if(jQuery('.wt-verticalscrollbar').length > 0){
		var _wt_verticalscrollbar = jQuery('.wt-verticalscrollbar');
		_wt_verticalscrollbar.mCustomScrollbar({
			axis:"y",
		});
	}

    tinymce.init({
        selector: 'textarea.wt-tinymceeditor',
        height: 300,
        theme: 'modern',
        plugins: [ 'code advlist autolink lists link image charmap print preview hr anchor pagebreak'],
        menubar: false,
        statusbar: false,
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify code',
        image_advtab: true,
        remove_script_host: false,
    });

    jQuery('.chosen-select').chosen();

    jQuery("#wt-postedsilder").owlCarousel({
        item: 1,
        loop:false,
        nav:true,
        margin: 10,
        autoplay:false,
        responsiveClass:true,
        navClass: ['wt-prev', 'wt-next'],
        navContainerClass: 'wt-slidernav',
        navText: ['<span class="lnr lnr-chevron-left"></span>', '<span class="lnr lnr-chevron-right"></span>'],
        responsive:{
            0:{items:1,},
            720:{items:2,},
        }
    });

    try {
		$('#wt-ourskill').appear(function () {
			jQuery('.wt-skillholder').each(function () {
				jQuery(this).find('.wt-skillbar').animate({
					width: jQuery(this).attr('data-percent')
				}, 2500);
			});
		});
    } catch (err) {}
});

if (document.getElementById("wt-header")) {
    const vmpassReset = new Vue({
        el: '#wt-header',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: { },
        methods: { }
    });
}

if (document.getElementById("message_center")) {
    const vmpassReset = new Vue({
        el: '#message_center',
        mounted: function () {},
        data: { },
        methods: { }
    });
}

if (document.getElementById("dashboard")) {
    const VueDashboard = new Vue({
        el: '#dashboard',
        mounted: function () {},
        data: { },
        methods: { }
    });
}

if (document.getElementById("home")) {
    const vmpassReset = new Vue({
        el: '#home',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: { },
        methods: { }
    });
}

if (document.getElementById("registration")) {
    const registration = new Vue({
        el: '#registration',
        mounted: function () {

        },
        data: {
            notificationSystem: {
                options: {
                  error: {
                    position: "topRight",
                    timeout: 4000
                  }
                }
            },
            step:1,
            user_email:'',
            first_name:'',
            last_name:'',
            form_step1: {
                email_error:'',
                is_email_error: false,
                first_name_error:'',
                is_first_name_error:false,
                last_name_error:'',
                is_last_name_error:false,
            },
            form_step2: {
                locations_error:'',
                is_locations_error:false,
                password_error:'',
                is_password_error:false,
                password_confirm_error:'',
                is_password_confirm_error:false,
                termsconditions_error:'',
                is_termsconditions_error: false,
            },
            loading: false,
            user_role:'employer',
            is_show:true
        },
        methods:{
            showError(error){
                return this.$toast.error(' ', error, this.notificationSystem.options.error);
            },
            prev: function() {
              this.step--;
            },
            next: function() {
              this.step++;
            },
            selectedRole: function(role) {
                if(role == 'employer') {
                    this.is_show = true;
                } else {
                    this.is_show = false;
                }
                console.log(role);
            },
            checkStep1: function(e) {
                this.form_step1.first_name_error = '';
                this.form_step1.is_first_name_error = false;
                this.form_step1.last_name_error = '';
                this.form_step1.is_last_name_error = false;
                this.form_step1.email_error = '';
                this.form_step1.is_email_error = false;
                var self = this;
                let register_Form = document.getElementById('register_form');
                let form_data = new FormData(register_Form);
                axios.post(APP_URL + '/register/form-step1-custom-errors',form_data)
                   .then(function (response) {
                       self.next();
                    })
                    .catch(function (error) {
                        if(error.response.data.errors.first_name) {
                            self.form_step1.first_name_error = error.response.data.errors.first_name[0];
                            self.form_step1.is_first_name_error = true;
                        }
                        if(error.response.data.errors.last_name) {
                            self.form_step1.last_name_error = error.response.data.errors.last_name[0];
                            self.form_step1.is_last_name_error = true;
                        }
                        if(error.response.data.errors.email) {
                            self.form_step1.email_error = error.response.data.errors.email[0];
                            self.form_step1.is_email_error = true;
                        }
                    });
                },
            checkStep2: function (e) {
                let register_Form = document.getElementById('register_form');
                let form_data = new FormData(register_Form);
                this.form_step2.password_error = '';
                this.form_step2.is_password_error = false;
                this.form_step2.password_confirm_error = '';
                this.form_step2.is_password_confirm_error = false;
                this.form_step2.termsconditions_error = '';
                this.form_step2.is_termsconditions_error = false;
                var self = this;
                axios.post(APP_URL + '/register/form-step2-custom-errors', form_data).
                    then(function (response) {
                        self.submitUser();
                    })
                    .catch(function (error) {
                        if(error.response.data.errors.password) {
                            self.form_step2.password_error = error.response.data.errors.password[0];
                            self.form_step2.is_password_error = true;
                        }
                        if(error.response.data.errors.password_confirmation) {
                            self.form_step2.password_confirm_error = error.response.data.errors.password_confirmation[0];
                            self.form_step2.is_password_confirm_error = true;
                        }
                        if(error.response.data.errors.termsconditions) {
                            self.form_step2.termsconditions_error = error.response.data.errors.termsconditions[0];
                            self.form_step2.is_termsconditions_error = true;
                        }
                    });
                },
            submitUser: function () {
                this.loading = true;
                let register_Form = document.getElementById('register_form');
                let form_data = new FormData(register_Form);
                form_data.append('email', this.user_email);
                form_data.append('first_name',this.first_name);
                form_data.append('last_name', this.last_name );
                var self = this;
                axios.post(APP_URL + '/register',form_data)
                    .then(function (response) {
                        self.loading = false;
                        if (response.data.type == 'success') {
                            self.next();
                        } else if (response.data.type == 'error') {
                            self.loading = false;
                            self.custom_error = true;
                            if (response.data.email_error) self.form_errors.push(response.data.email_error);
                            if (response.data.password_error) self.form_errors.push(response.data.password_error);
                        }
                    })
                    .catch(function (error) {
                        self.loading = false;
                        if(error.response.status == 500) {
                            self.showError(error.response.statusText);
                        }
                    });
            },
            verifyCode: function () {
                this.loading = true;
                let register_Form = document.getElementById('verification_form');
                let form_data = new FormData(register_Form);
                var self = this;
                axios.post(APP_URL + '/register/verify-user-code',form_data)
                  .then(function (response) {
                    self.loading = false;
                      if (response.data.type == 'success') {
                            self.next();
                      } else if (response.data.type == 'error') {
                            self.showError(response.data.message);
                      }
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            loginRegisterUser: function() {
                var self = this;
                axios.post(APP_URL + '/register/login-register-user')
                  .then(function (response) {
                        if (response.data.type == 'success') {
                            window.location.href = APP_URL + '/'+ response.data.role +'/dashboard';
                        } else if (response.data.type == 'error') {
                            self.error_message = response.data.message;
                        }
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            }
          }
    });
}

if (document.getElementById("skill-list")) {
    const vmskillList = new Vue({
        el: '#skill-list',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            skillID: "",
        },
    });
}

if (document.getElementById("pass-reset")) {
    const vmpassReset = new Vue({
        el: '#pass-reset',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: { },
        methods: { }
    });
}

if (document.getElementById("dpt-list")) {
    const vmdptList = new Vue({
        el: '#dpt-list',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            dptID: "",
        },
        methods: { }
    });
}

if (document.getElementById("pages-list")) {
    const vmpageList = new Vue({
        el: '#pages-list',
        mounted: function () {},
        data: {
            pageID: "",
            notificationSystem: {
                options: {
                    success: {
                        position: "topRight",
                        timeout: 4000,
                        class:'success_notification'
                    },
                    error: {
                        position: "topRight",
                        timeout: 4000,
                        class:'error_notification'
                    },
                }
            },
        },
        methods: {
            showMessage(message){
                return this.$toast.success(' ', message, this.notificationSystem.options.success);
            },
            showError(error){
                return this.$toast.error(' ', error, this.notificationSystem.options.error);
            },
            submitPage: function(msg) {
                let page_Form = document.getElementById('pages');
                let form_data = new FormData(page_Form);
                var description = tinyMCE.get('wt-tinymceeditor').getContent();
                form_data.append('content', description);
                var self = this;
                axios.post(APP_URL + '/admin/store-page',form_data)
                .then(function (response) {
                    if (response.data.type == 'success') {
                        self.showMessage(msg);
                        setTimeout(function () {
                            window.location.replace(APP_URL+'/admin/pages');
                        }, 4000)

                    }
                })
                .catch(function (error) {
                    if(error.response.data.errors.title) {
                        self.showError(error.response.data.errors.title[0]);
                    }
                    if(error.response.data.errors.content) {
                        self.showError(error.response.data.errors.content[0]);
                    }
                });
            }
        }
    });
}

if (document.getElementById("reviews")) {
    const vmdptList = new Vue({
        el: '#reviews',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            optionID: "",
        },
        methods: { }
    });
}

if (document.getElementById("cat-list")) {
    const vmcatList = new Vue({
        el: '#cat-list',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            uploaded_image: false,
            color:'',
            rgb:'',
            wheel:'',
        },
        components: { Verte },
        methods: {
           removeImage: function (id) {
                this.uploaded_image = true;
                document.getElementById(id).value = '';
            },
        }
    });
}

if (document.getElementById("badge-list")) {
    const vmbadge = new Vue({
        el: '#badge-list',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        created: function(){
            this.getBadgeColor();
        },
        components: { Verte },
        data: {
            uploaded_image: false,
            color:'',
        },
        methods: {
           removeImage: function (id) {
                this.uploaded_image = true;
                document.getElementById(id).value = '';
            },
            getBadgeColor: function(){
                var self = this;
                var segment_str = window.location.pathname;
                var segment_array = segment_str.split( '/' );
                var id = segment_array[segment_array.length - 1];
                 axios.post(APP_URL + '/badge/get-color',{
                     id: id,
                 })
                .then(function (response) {
                    if(response.data.type = 'success') {
                        self.color = response.data.color;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    });
}

if (document.getElementById("lang-list")) {
    const vmdptList = new Vue({
        el: '#lang-list',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            langID: "",
        },
        methods: { }
    });
}

if (document.getElementById("location")) {
    var location = new Vue({
        el: '#location',
        mounted: function() {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            locationID: "",
            message:'',
            alert_message: '',
            custom_error: false,
            uploaded_image:false,
        },
        methods: {
            removeImage: function (id) {
                this.uploaded_image = true;
                document.getElementById(id).value = '';
            },
         }
    })
}
if (document.getElementById("user_profile")) {
    const freelancerProfile = new Vue({
        el: '#user_profile',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        created: function() {
            Event.$on('award-component-render', (data) => {
                this.server_error = data.error;
            })
            Event.$on('experience-component-render', (data) => {
                this.experience_server_error = data.error;
            })
        },
        data: {
            server_error:'',
            experience_server_error:'',
            disable_btn:'',
            saved_class:'far fa-heart',
            job_saved_class:'far fa-heart',
            click_to_save:'',
            text:'Click to Save',
            follow_text: 'Click To Follow',
            disable_job_save:'',
            disable_follow:'',
            job_click_to_save:'',
            avater_id: 'profile_image',
            banner_id: 'profile_banner',
            avater_ref: 'profile_image_ref',
            banner_ref: 'profile_banner_ref',
            uploaded_image: false,
            uploaded_banner: false,
            report: {
                reason:'',
                description:'',
                id:'',
                model:'App\\User',
                report_type: '',
            },
            notificationSystem: {
                options: {
                  success: {
                    position: "topRight",
                    timeout: 3000,
                    class:'success_notification'
                  },
                  error: {
                    position: "topRight",
                    timeout: 4000,
                    class:'error_notification'
                  },
                  completed: {
                    position: 'center',
                    timeout: 1000,
                    class:'complete_notification'
                  },
                  info: {
                    overlay: true,
                    zindex: 999,
                    position: 'center',
                    timeout: 3000,
                    class:'info_notification',
                    onClosing: function(instance, toast, closedBy){
                        freelancerProfile.showCompleted('Profile Updated Successfully');
                    }
                  }
                }
            },
            is_popup: false,
        },
        ready: function () {

         },
        methods: {
            showCompleted(message){
                return this.$toast.success(' ', message, this.notificationSystem.options.completed);
            },
            showInfo(message){
                return this.$toast.info(' ', message, this.notificationSystem.options.info);
            },
            showMessage(message){
                return this.$toast.success(' ', message, this.notificationSystem.options.success);
            },
            showError(error){
                return this.$toast.error(' ', error, this.notificationSystem.options.error);
            },
            submitProfileSettings: function () {
                this.loading = true;
                var self = this;
                var profile_form = document.getElementById('profile_form');
                let form_data = new FormData(profile_form);
                axios.post(APP_URL + '/freelancer/profile-settings',form_data)
                    .then(function (response) {
                        if (response.data.type == 'success') {
                            self.next();
                      } else if (response.data.type == 'error') {
                            self.custom_error = true;
                            if (response.data.email_error) self.form_errors.push(response.data.email_error);
                            if (response.data.password_error) self.form_errors.push(response.data.password_error);
                      }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            removeImage: function (event) {
                this.uploaded_image = true;
                document.getElementById("hidden_avater").value = '';
            },
            removeBanner: function (event) {
                this.uploaded_banner = true;
                document.getElementById("hidden_banner").value = '';
            },
            submitFreelancerProfile: function () {
                var self = this;
                var profile_data = document.getElementById('freelancer_profile');
                let form_data = new FormData(profile_data);
                axios.post(APP_URL + '/freelancer/store-profile-settings',form_data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.showInfo('Saving Profile');
                    } else if(response.data.type == 'error') {
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {
                    if (error.response.data.errors.first_name) {
                        self.showError(error.response.data.errors.first_name[0]);
                    }
                    if (error.response.data.errors.last_name) {
                        self.showError(error.response.data.errors.last_name[0]);
                    }
                    if (error.response.data.errors.gender) {
                        self.showError(error.response.data.errors.gender[0]);
                    }
                });
            },
            submitExperienceEduction: function () {
                var self = this;
                var exp_edu_data = document.getElementById('experience_form');
                let form_data = new FormData(exp_edu_data);
                axios.post(APP_URL + '/freelancer/store-experience-settings',form_data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.showInfo(response.data.message);
                    } else if(response.data.type == 'error') {
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {
                    if (error.response.status == 422){
                        self.showError(self.experience_server_error);
                    }
                });
            },
            submitPaymentSettings: function () {
                var self = this;
                var payment = document.getElementById('payment_settings');
                let form_data = new FormData(payment);
                axios.post(APP_URL + '/freelancer/store-payment-settings',form_data)
                .then(function (response) {
                    self.showInfo(response.data.processing);
                    setTimeout(function () {
                        window.location.replace(APP_URL+'/freelancer/dashboard');
                    }, 4000);
                })
                .catch(function (error) {
                    if(error.response.data.errors.payout_id) {
                        self.showError(error.response.data.errors.payout_id[0]);
                    }
                });
            },
            submitAwardsProjects: function () {
                var self = this;
                var awards_projects = document.getElementById('awards_projects');
                console.log(awards_projects);
                let form_data = new FormData(awards_projects);
                axios.post(APP_URL + '/freelancer/store-project-award-settings',form_data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.showInfo(response.data.message);
                    } else if(response.data.type == 'error') {
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {
                    if (error.response.status == 422){
                        self.showError(self.server_error);
                    }
                });
            },
            submitEmployerProfile: function () {
                var self = this;
                var profile_data = document.getElementById('employer_data');
                let form_data = new FormData(profile_data);
                axios.post(APP_URL + '/employer/store-profile-settings',form_data)
                .then(function (response) {
                    self.showInfo(response.data.process);
                    setTimeout(function () {
                        window.location.replace(APP_URL+'/employer/dashboard');
                    }, 4000);
                })
                .catch(function (error) {
                    if (error.response.data.errors.first_name) {
                        self.showError(error.response.data.errors.first_name[0]);
                    }
                    if (error.response.data.errors.last_name) {
                        self.showError(error.response.data.errors.last_name[0]);
                    }
                });
            },
            submitAdminProfile: function () {
                var self = this;
                var profile_data = document.getElementById('admin_data');
                let form_data = new FormData(profile_data);
                axios.post(APP_URL + '/admin/store-profile-settings',form_data)
                .then(function (response) {
                    self.showInfo(response.data.process);
                    setTimeout(function () {
                        window.location.replace(APP_URL+'/admin/profile');
                    }, 4000);
                })
                .catch(function (error) {
                    if (error.response.data.errors.first_name) {
                        self.showError(error.response.data.errors.first_name[0]);
                    }
                    if (error.response.data.errors.last_name) {
                        self.showError(error.response.data.errors.last_name[0]);
                    }
                });
            },
            sendOffer: function (auth_user){
                if (auth_user == 1) {
                    this.$refs.myModalRef.show();
                } else {
                    jQuery('.wt-loginarea .wt-loginformhold').slideToggle();
                }
            },
            submitProjectOffer: function (id) {
                let offer_form = document.getElementById('send-offer-form');
                let form_data = new FormData(offer_form);
                form_data.append('freelancer_id', id);
                var self = this;
                axios.post(APP_URL + '/store/project-offer',form_data)
                    .then(function (response) {
                        if(response.data.type == 'success') {
                            self.$refs.myModalRef.hide();
                            self.showInfo(response.data.progressing);
                            self.success_message = response.data.message;
                        } else if(response.data.type == 'error') {
                            self.showError(response.data.message);
                        }
                    })
                    .catch(function (error) {});
            },
            openChatBox: function() {
                if (this.is_popup == false) {
                    this.is_popup = true;
                } else {
                    this.is_popup = false;
                }
            },
            submitReport: function(id, report_type) {
                this.report.report_type =  report_type;
                this.report.id = id;
                var self = this;
                axios.post(APP_URL + '/submit-report',self.report)
                .then(function (response) {
                    if (response.data.type == 'success') {
                        self.showMessage(response.data.message);
                    } else if (response.data.type == 'error') {
                        self.showError(response.data.message);
                    }

                })
                .catch(error => {
                    if (error.response.status == 422){
                        if (error.response.data.errors.description) {
                            self.showError(error.response.data.errors.description[0]);
                        }
                        if (error.response.data.errors.reason) {
                            self.showError(error.response.data.errors.reason[0]);
                        }
                     }
                });
            },
            add_wishlist: function(element_id, id, column, saved_text) {
                var self = this;
                axios.post(APP_URL + '/user/add-wishlist',{
                    id : id,
                    column : column,
                })
                .then(function (response) {
                    if (response.data.authentication ==true) {
                        if (column == 'saved_freelancer') {
                            jQuery('#'+element_id).parents('li').addClass('wt-btndisbaled');
                            jQuery('#'+element_id).addClass('wt-clicksave');
                            jQuery('#'+element_id).find('.save_text').text(saved_text);
                            self.disable_btn = 'wt-btndisbaled';
                            self.text = 'Save';
                            self.saved_class = 'fa fa-heart';
                            self.click_to_save = 'wt-clicksave'
                        }
                        else if (column == 'saved_employers') {
                            jQuery('#'+element_id).addClass('wt-btndisbaled wt-clicksave');
                            jQuery('#'+element_id).text(saved_text);
                            jQuery('#'+element_id).parents('.wt-clicksavearea').find('i').addClass('fa fa-heart');
                            self.disable_follow = 'wt-btndisbaled';
                            self.follow_text = saved_text;
                        }
                        else if (column == 'saved_jobs') {
                            jQuery('#'+element_id).parents('li').addClass('wt-btndisbaled');
                            jQuery('#'+element_id).addClass('wt-clicksave');
                            jQuery('#'+element_id).find('.save_text').text(saved_text);
                        }
                        self.showMessage(response.data.message);
                    } else {
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getWishlist: function(){
                var self = this;
                var segment_str = window.location.pathname;
                var segment_array = segment_str.split( '/' );
                var slug = segment_array[segment_array.length - 1];
                axios.post(APP_URL + '/profile/get-wishlist',{
                    slug: slug
                })
                .then(function (response) {
                    if (response.data.user_type == 'freelancer') {
                        if (response.data.current_freelancer == 'true') {
                            self.disable_btn = 'wt-btndisbaled';
                            self.text = 'Saved';
                            self.saved_class = 'fa fa-heart';
                        }
                    } else if (response.data.user_type == 'employer') {
                        if (response.data.employer_jobs == 'true') {
                            self.disable_btn = 'wt-btndisbaled';
                            self.text = 'Saved';
                            self.saved_class = 'fa fa-heart';
                        }
                        if (response.data.current_employer == 'true') {
                            self.disable_follow = 'wt-btndisbaled';
                            self.follow_text = 'following';
                        }
                    }
                });
            },
        }
    });
}

//Settings
if (document.getElementById("settings")) {
    const VueSettings = new Vue({
    el: "#settings",
    mounted: function() {
        //Delete Social
        var count_social_length = jQuery('.social-icons-content').find('.wrap-social-icons').length;
        count_social_length = count_social_length - 1;
        this.social.count = count_social_length;
        jQuery(document).on('click', '.delete-social', function (e) {
            e.preventDefault();
            var _this = jQuery(this);
            _this.parents('.wrap-social-icons').remove();
        });
        //Delete Search
        var count_social_length = jQuery('.search-content').find('.wrap-search').length;
        count_social_length = count_social_length - 1;
        this.social.count = count_social_length;
        jQuery(document).on('click', '.delete-search', function (e) {
            e.preventDefault();
            var _this = jQuery(this);
            _this.parents('.wrap-search').remove();
        });
    },

    data:{
        uploaded_logo: false,
        uploaded_banner: false,
        uploaded_avatar: false,
        uploaded_banner_bg: false,
        uploaded_banner_image: false,
        uploaded_section_bg: false,
        uploaded_download_app_img: false,
        footer_logo: false,
        logo: false,
        success_message:'',
        notificationSystem: {
            options: {
              success: {
                position: "topRight",
                timeout: 4000
              },
              error: {
                position: "topRight",
                timeout: 7000
              },
              completed: {
                position: 'center',
                timeout: 1000,
                progressBar: false
              },
              info: {
                overlay: true,
                zindex: 999,
                position: 'center',
                timeout: 3000,
                onClosing: function(instance, toast, closedBy){
                    VueSettings.showCompleted(VueSettings.success_message);
                }
              }
            }
        },
        social: {
            social_name: 'Select social icon',
            social_url: '',
            count: 0,
            success_message: '',
            loading: false
        },
        search: {
            search_name: 'Add Title',
            search_url: '',
            count: 0,
            success_message: '',
            loading: false
        },
        socials: [],
        first_social_name: '',
        first_social_url: '',
        searches: [],
        first_search_title: '',
        first_search_url: '',
    },
    created: function() { },
    ready: function () { },
    methods: {
        addSocial: function () {
            this.socials.push(Vue.util.extend({}, this.social, this.social.count++))
        },
        removeSocial: function (index) {
            Vue.delete(this.socials, index);
        },
        addSearchItem: function () {
            this.searches.push(Vue.util.extend({}, this.search, this.search.count++))
        },
        removeSearchItem: function (index) {
            Vue.delete(this.searches, index);
        },
        showCompleted(message){
            return this.$toast.success(' ', message, this.notificationSystem.options.completed);
        },
        showInfo(message){
            return this.$toast.info(' ', message, this.notificationSystem.options.info);
        },
        showMessage(message){
            return this.$toast.success('Success', message, this.notificationSystem.options.success);
        },
        showError(error){
            return this.$toast.error(' ', error, this.notificationSystem.options.error);
        },
        submitGeneralSettings: function () {
            let settings_form = document.getElementById('general-setting-form');
            let form_data = new FormData(settings_form);
            var self = this;
            axios.post(APP_URL + '/admin/store/settings',form_data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.success_message = response.data.message;
                        self.showInfo(response.data.progressing);
                    }
                })
                .catch(function (error) {});
        },
        submitFooterSettings: function () {
            let footersettings = document.getElementById('footer-setting-form');
            let data = new FormData(footersettings);
            var self = this;
            axios.post(APP_URL + '/admin/store/footer-settings',data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.success_message = response.data.message;
                        self.showInfo(response.data.progressing);
                    }
                })
                .catch(function (error) {});
        },
        submitSocialSettings: function () {
            let socialsettings = document.getElementById('social-management');
            let data = new FormData(socialsettings);
            var self = this;
            axios.post(APP_URL + '/admin/store/social-settings',data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.success_message = response.data.message;
                        self.showInfo(response.data.progressing);
                    }
                })
                .catch(function (error) {});
        },
        submitSearchMenu: function () {
            let searchMenu = document.getElementById('search-menu');
            let data = new FormData(searchMenu);
            var self = this;
            axios.post(APP_URL + '/admin/store/search-menu',data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.success_message = response.data.message;
                        self.showInfo(response.data.progressing);
                    }
                })
                .catch(function (error) {
                    if (error.response.data.errors.menu_title) {
                        self.showError(error.response.data.errors.menu_title[0]);
                    }
                    if (error.response.data.errors.search.title) {
                        self.showError(error.response.data.errors.search[this.search.count++][title][0]);
                    }
                    if (error.response.data.errors.search.url) {
                        self.showError(error.response.data.errors.search[this.search.count++][url][0]);
                    }
                });
        },
        submitCommisionSettings: function () {
            let commision_settings = document.getElementById('comission-form');
            let data = new FormData(commision_settings);
            var self = this;
            axios.post(APP_URL + '/admin/store/commision-settings',data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.success_message = response.data.message;
                        self.showInfo(response.data.progressing);
                    }
                })
                .catch(function (error) {});
        },
        submitPaypalSettings: function () {
            let payment_settings = document.getElementById('payment-form');
            let data = new FormData(payment_settings);
            var self = this;
            axios.post(APP_URL + '/admin/store/payment-settings',data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.success_message = response.data.message;
                        self.showInfo(response.data.progressing);
                    }
                })
                .catch(function (error) {
                    if (error.response.data.errors.client_id) {
                        self.showError(error.response.data.errors.client_id[0]);
                    }
                    if (error.response.data.errors.paypal_password) {
                        self.showError(error.response.data.errors.paypal_password[0]);
                    }
                    if (error.response.data.errors.paypal_secret) {
                        self.showError(error.response.data.errors.paypal_secret[0]);
                    }
                });
        },
        emailContent: function(reference){
            this.$refs[reference].show();
        },
        submitEmailSettings: function () {
            let settings_form = document.getElementById('email-setting-form');
            let form_data = new FormData(settings_form);
            var self = this;
            axios.post(APP_URL + '/admin/store/email-settings',form_data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.success_message = response.data.message;
                        self.showInfo(response.data.progressing);
                    }
                })
                .catch(function (error) {});
        },
        submitHomeSettings: function () {
            let settings_form = document.getElementById('home-settings-form');
            let form_data = new FormData(settings_form);
            var description = tinyMCE.get('wt-tinymceeditor').getContent();
            form_data.append('app_desc', description);
            var self = this;
            axios.post(APP_URL + '/admin/store/home-settings',form_data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.success_message = response.data.message;
                        self.showInfo(response.data.progressing);
                    }
                })
                .catch(function (error) {});
        },
        removeImage: function (id) {
            if(id == 'hidden_site_logo') {
                this.logo = true;
            }
            if(id == 'hidden_logo') {
                this.uploaded_logo = true;
            }
            if(id == 'hidden_banner') {
                this.uploaded_banner = true;
            }
            if(id == 'hidden_avatar') {
                this.uploaded_avatar = true;
            }
            if(id == 'hidden_home_banner') {
                this.uploaded_banner_bg = true;
            }
            if(id == 'hidden_banner_image') {
                this.uploaded_banner_image = true;
            }
            if(id == 'hidden_section_bg') {
                this.uploaded_section_bg = true;
            }
            if(id == 'hidden_download_app_img') {
                this.uploaded_download_app_img = true;
            }
            if(id == 'hidden_site_footer_logo') {
                this.footer_logo = true;
            }
            document.getElementById(id).value = '';
        },
        importDemo: function(text) {
            this.$swal({
                title: text,
                type: "warning",
                customContainerClass:'hire_popup',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true,
                showLoaderOnConfirm: false
              }).then((result) => {
                if(result.value) {
                    window.location.replace(APP_URL+'/admin/import-demo');
                } else {
                    this.$swal.close()
                }
              })
        },
        removeDemoContent: function(text) {
            this.$swal({
                title: text,
                type: "warning",
                customContainerClass:'hire_popup',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true,
                showLoaderOnConfirm: false
              }).then((result) => {
                if(result.value) {
                    window.location.replace(APP_URL+'/admin/remove-demo');
                } else {
                    this.$swal.close()
                }
              })
        },
    }
});
}
//Profile Settings
if (document.getElementById("profile_settings")) {
    const switchButton = new Vue({
        el: "#profile_settings",
        mounted: function() {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: function() {
            return {
                profile_blocked: true,
                profile_searchable: true,
                weekly_alerts: true,
                message_alerts: false,
                success_message:'',
                notificationSystem: {
                    options: {
                    success: {
                        position: "topRight",
                        timeout: 4000
                    },
                    error: {
                        position: "topRight",
                        timeout: 7000
                    },
                    completed: {
                        position: 'center',
                        timeout: 1000,
                        progressBar: false
                    },
                    info: {
                        overlay: true,
                        zindex: 999,
                        position: 'center',
                        timeout: 3000,
                        onClosing: function(instance, toast, closedBy){
                            VueSettings.showCompleted(VueSettings.success_message);
                        }
                    }
                    }
                }

            };
        },
        created: function() {
            this.getUserEmailNotification();
        },
        ready: function () {
            this.deleteAccount();
        },
        methods: {
            showCompleted(message){
                return this.$toast.success(' ', message, this.notificationSystem.options.completed);
            },
            showInfo(message){
                return this.$toast.info(' ', message, this.notificationSystem.options.info);
            },
            showMessage(message){
                return this.$toast.success('Success', message, this.notificationSystem.options.success);
            },
            showError(error){
                return this.$toast.error(' ', error, this.notificationSystem.options.error);
            },
            deleteAccount: function (event) {
                var self = this;
                var delete_acc_form = document.getElementById('delete_acc_form');
                let form_data       = new FormData(delete_acc_form);
                this.$swal({
                    title: 'Delete Account',
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
                        axios.post(APP_URL + '/profile/settings/delete-user',form_data)
                        .then(function (response) {
                            if (response.data.type === 'warning') {
                                self.showError(response.data.msg);
                            } else {
                                setTimeout(function () {
                                    swal({
                                        type: "success"
                                    })
                                },
                                self.showInfo(response.data.acc_del), 1000);
                            window.location.href = APP_URL + '/';
                            }
                        })
                        .catch(function (error) {
                            if(error.response.data.errors.old_password) {
                                self.showError(error.response.data.errors.old_password[0]);
                            }
                            if(error.response.data.errors.retype_password) {
                                self.showError(error.response.data.errors.retype_password[0]);
                            }
                        });
                    } else {
                        this.$swal.close()
                    }
                })
            },
            deleteUser: function (id) {
                var self = this;
                this.$swal({
                    title: 'Delete User',
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
                        axios.post(APP_URL + '/admin/delete-user',{
                            user_id : id
                        })
                        .then(function (response) {
                            setTimeout(function () {
                                swal({
                                    title: this.title,
                                    text: 'User Deleted',
                                    type: "success"
                                })
                            }, 500);
                            self.$swal('Deleted', 'User Deleted', 'success')
                            window.location.replace(APP_URL+'/users');
                            jQuery('.del-user-' + user_id).remove();
                        })
                    } else {
                        this.$swal.close()
                    }
                })
            },
            getUserEmailNotification: function(){
                let self = this;
                axios.get(APP_URL + '/profile/settings/get-user-notification-settings')
                .then(function (response) {
                    if (response.data.type == 'success') {
                        if ((response.data.weekly_alerts == 'true')) {
                            self.weekly_alerts = true;
                        } else {
                            self.weekly_alerts = false;
                        }
                        if ((response.data.message_alerts == 'true')) {
                            self.message_alerts = true;
                        } else {
                            self.message_alerts = false;
                        }
                    }
                });
            },
            getUserEmailNotification: function(){
                let self = this;
                axios.get(APP_URL + '/profile/settings/get-user-searchable-settings')
                .then(function (response) {
                    if (response.data.type == 'success') {
                        if ((response.data.profile_searchable == 'true')) {
                            self.profile_searchable = true;
                        } else {
                            self.profile_searchable = false;
                        }
                        if ((response.data.profile_blocked == 'true')) {
                            self.profile_blocked = true;
                        } else {
                            self.profile_blocked = false;
                        }
                    }
                });
            },
        }

    });
}

if (document.getElementById("post_job")) {
    const vmpostJob = new Vue({
        el: '#post_job',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            title:'',
            project_level:'',
            job_duration:'',
            freelancer_level:'',
            english_level:'',
            message:'',
            form_errors:[],
            custom_error: false,
            is_show: false,
            loading: false,
            show_attachments: false,
            is_featured: false,
            is_progress: false,
            is_completed: false,
            errors: '',
            notificationSystem: {
                options: {
                  success: {
                    position: "topRight",
                    timeout: 4000
                  },
                  error: {
                    position: "topRight",
                    timeout: 7000
                  },
                  completed: {
                    position: 'center',
                    timeout: 1000,
                    progressBar: false
                  },
                  info: {
                    overlay: true,
                    zindex: 999,
                    position: 'center',
                    timeout: 3000,
                    onClosing: function(instance, toast, closedBy){
                        vmpostJob.showCompleted('Process Completed Successfully');
                    }
                  }
                }
            }
        },
        created: function() {
            this.getSettings();
        },
        methods: {
                showCompleted(message){
                    return this.$toast.success(' ', message, this.notificationSystem.options.completed);
                },
                showInfo(message){
                    return this.$toast.info(' ', message, this.notificationSystem.options.info);
                },
                showMessage(message){
                    return this.$toast.success('Success', message, this.notificationSystem.options.success);
                },
                showError(error){
                    return this.$toast.error(' ', error, this.notificationSystem.options.error);
                },
                submitJob: function () {
                    this.loading = true;
                    let register_Form = document.getElementById('post_job_form');
                    let form_data = new FormData(register_Form);
                    var description = tinyMCE.get('wt-tinymceeditor').getContent();
                    form_data.append('description', description);
                    var self = this;
                    axios.post(APP_URL + '/job/post-job',form_data)
                        .then(function (response) {
                            if (response.data.type == 'success') {
                                self.loading = false;
                                self.showInfo('Job is Submitting');
                                setTimeout(function () {
                                    window.location.replace(APP_URL+'/employer/dashboard/manage-jobs');
                                }, 4000);
                            } else {
                                self.loading = false;
                                self.showError(response.data.message);
                            }
                        })
                        .catch(function (error) {
                            self.loading = false;
                            if(error.response.data.errors.job_duration) {
                                self.showError(error.response.data.errors.job_duration[0]);
                            }
                            if(error.response.data.errors.english_level) {
                                self.showError(error.response.data.errors.english_level[0]);
                            }
                            if(error.response.data.errors.title) {
                                self.showError(error.response.data.errors.title[0]);
                            }
                            if(error.response.data.errors.project_levels) {
                                self.showError(error.response.data.errors.project_levels[0]);
                            }
                            if(error.response.data.errors.project_cost) {
                                self.showError(error.response.data.errors.project_cost[0]);
                            }
                            if(error.response.data.errors.description) {
                                self.showError(error.response.data.errors.description[0]);
                            }
                        });
                },
                updateJob: function (id) {
                    this.loading = true;
                    let register_Form = document.getElementById('job_edit_form');
                    let form_data = new FormData(register_Form);
                    var description = tinyMCE.get('wt-tinymceeditor').getContent();
                    form_data.append('description', description);
                    form_data.append('id', id);
                    var self = this;
                    axios.post(APP_URL + '/job/update-job',form_data)
                        .then(function (response) {
                            self.loading = false;
                            self.showInfo('Job is updating');
                            if(response.data.type == 'success') {
                                setTimeout(function () {
                                    window.location.replace(APP_URL+'/employer/dashboard/manage-jobs');
                                }, 4000);
                            } else {
                                self.showError(response.data.message);
                            }
                        })
                        .catch(function (error) {
                            self.loading = false;
                            if(error.response.data.errors.job_duration) {
                                self.showError(error.response.data.errors.job_duration[0]);
                            }
                            if(error.response.data.errors.english_level) {
                                self.showError(error.response.data.errors.english_level[0]);
                            }
                            if(error.response.data.errors.title) {
                                self.showError(error.response.data.errors.title[0]);
                            }
                            if(error.response.data.errors.project_levels) {
                                self.showError(error.response.data.errors.project_levels[0]);
                            }
                            if(error.response.data.errors.project_cost) {
                                self.showError(error.response.data.errors.project_cost[0]);
                            }
                            if(error.response.data.errors.description) {
                                self.showError(error.response.data.errors.description[0]);
                            }
                        });
                },
                getSettings: function(){
                    let self = this;
                    var segment_str = window.location.pathname;
                    var segment_array = segment_str.split( '/' );
                    var slug = segment_array[segment_array.length - 1];
                    axios.post(APP_URL + '/job/get-job-settings',{
                        slug: slug
                    })
                    .then(function (response) {
                        if (response.data.type == 'success') {
                            if ((response.data.is_featured == 'true')) {
                                self.is_featured = true;
                            } else {
                                self.is_featured = false;
                            }
                            if ((response.data.show_attachments == 'true')) {
                                self.show_attachments = true;
                            } else {
                                self.show_attachments = false;
                            }
                        }
                    });
                },
                deleteAttachment: function(id){
                    jQuery('#' + id).remove();
                }
            }
        });
}

if (document.getElementById("jobs")) {
    const jobVue = new Vue({
        el: '#jobs',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        created: function() {
        },
        data: {
            proposal:{
                amount:'Enter Your proposal amount',
                deduction:'00.00',
                total:'00.00',
                completion_time:'',
                description:'',
            },
            report: {
                reason:'',
                description:'',
                id:'',
                model:'App\\Job',
                report_type: '',
            },
            form_errors:[],
            custom_error: false,
            loading: false,
            message:'',
            disable_btn:'',
            saved_class:'',
            heart_class:'far fa-heart',
            text:'Click to Save',
            follow_text: 'Click To Follow',
            disable_follow:'',
            notificationSystem: {
                options: {
                  success: {
                    position: "topRight",
                    timeout: 3000
                  },
                  error: {
                    position: "topRight",
                    timeout: 4000
                  },
                  completed: {
                    position: 'center',
                    timeout: 1000,
                  },
                  info: {
                    overlay: true,
                    zindex: 999,
                    position: 'center',
                    timeout: 3000,
                    onClosing: function(instance, toast, closedBy){
                        vmpostJob.showCompleted('Process Completed Successfully');
                        }
                    },
                    message: {
                        position: 'center',
                        timeout: 900,
                        progressBar:false
                  }
                }
            },
         },
        methods: {
            showCompleted(message){
                return this.$toast.success(' ', message, this.notificationSystem.options.completed);
            },
            showInfo(message){
                return this.$toast.info(' ', message, this.notificationSystem.options.info);
            },
            showMessage(message){
                return this.$toast.success(' ', message, this.notificationSystem.options.success);
            },
            showError(error){
                return this.$toast.error(' ', error, this.notificationSystem.options.error);
            },
            showMessage(message){
                return this.$toast.success(' ', message, this.notificationSystem.options.message);
            },
            add_wishlist: function(element_id, id, column, saved_text) {
                var self = this;
                axios.post(APP_URL + '/user/add-wishlist',{
                    id : id,
                    column : column,
                })
                .then(function (response) {
                    if (response.data.authentication ==true) {
                        if (column == 'saved_jobs') {
                            jQuery('#'+element_id).parents('li').addClass('wt-btndisbaled');
                            jQuery('#'+element_id).addClass('wt-clicksave');
                            jQuery('#'+element_id).find('.save_text').text(saved_text);
                            self.disable_btn = 'wt-btndisbaled wt-clicksave';
                            self.text = saved_text;
                            self.heart_class = 'fa fa-heart';
                        }
                        if (column == 'saved_employers') {
                            self.disable_follow = 'wt-btndisbaled';
                            self.follow_text = saved_text;
                        }
                        self.showMessage(response.data.message);
                    } else {
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            check_auth: function(url){
                var self = this;
                axios.get(APP_URL + '/check-proposal-auth-user')
                .then(function (response) {
                    if (response.data.auth == 1) {
                        window.location.replace(url);
                    } else {
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {

                });
            },
            calculate_amount: function(commission) {
                console.log(commission);
                this.proposal.deduction = (this.proposal.amount / 100) * commission;
                this.proposal.total = this.proposal.amount - this.proposal.deduction;
            },
            submitJobProposal: function (id) {
                this.loading = true;
                this.custom_error = false;
                let propsal_form = document.getElementById('send-propsal');
                let form_data = new FormData(propsal_form);
                form_data.append('id', id);
                var self = this;
                axios.post(APP_URL + '/proposal/submit-proposal',form_data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        self.loading = false;
                        self.showCompleted(response.data.message);
                        setTimeout(function () {
                            window.location.replace(APP_URL+'/freelancer/proposals');
                        }, 1050);
                    } else {
                        self.loading = false;
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {
                    self.loading = false;
                    if(error.response.data.errors.amount) {
                        self.showError(error.response.data.errors.amount[0]);
                    }
                    if(error.response.data.errors.completion_time) {
                        self.showError(error.response.data.errors.completion_time[0]);
                    }
                    if(error.response.data.errors.description) {
                        self.showError(error.response.data.errors.description[0]);
                    }
                });
            },
            submitReport: function(id, report_type) {
                this.report.report_type =  report_type;
                this.report.id = id;
                var self = this;
                axios.post(APP_URL + '/submit-report',self.report)
                .then(function (response) {
                    if (response.data.type == 'success') {
                        self.showMessage(response.data.message);
                    } else if (response.data.type == 'error') {
                        self.showError(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status == 422){
                        if (error.response.data.errors.description) {
                            self.showError(error.response.data.errors.description[0]);
                        }
                        if (error.response.data.errors.reason) {
                            self.showError(error.response.data.errors.reason[0]);
                        }
                     }
                });
            },
            hireFreelancer: function(id) {
                this.$swal({
                    title: 'Do you want to hire this freelancer',
                    type: "warning",
                    customContainerClass:'hire_popup',
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: false
                  }).then((result) => {
                    if(result.value) {
                        window.location.replace(APP_URL+'/payment-process/'+id);
                    } else {
                        this.$swal.close()
                    }
                  })
            },
            showCoverLetter: function(id) {
                var modal_ref = 'myModalRef-'+id;
                this.$refs[modal_ref].show();
            },
            downloadAttachments: function(form_id) {
                document.getElementById(form_id).submit();
            },
            jobStatus: function(id, proposal_id) {
                var job_status = document.getElementById("job_status");
                var status = job_status.options[job_status.selectedIndex].value;
                if (status == "cancelled") {
                    this.$swal({
                        title: 'Reason',
                        text: 'Submit your reason for cancelling this proposal',
                        type: 'info',
                        input: 'textarea',
                        confirmButtonText: 'Send request',
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        inputValidator: (textarea) => {
                            return new Promise((resolve) => {
                              if (textarea != '') {
                                resolve()
                              } else {
                                resolve('text field is required.')
                              }
                            })
                        },
                        preConfirm: (textarea) => {
                            var self = this;
                            return axios.post(APP_URL + '/submit-report',{
                                reason: 'proposal cancel',
                                report_type: 'proposal_cancel',
                                description:textarea,
                                id:id,
                                model:'App\\Job',
                                proposal_id:proposal_id
                            })
                            .then(function (response) {
                                if(response.data.type == 'success') {
                                    self.showCompleted(response.data.message);
                                    setTimeout(function () {
                                        window.location.replace(APP_URL+'/employer/dashboard/manage-jobs');
                                    }, 1500);
                                }
                            })
                            .catch(error => {
                                if (error.response.status == 422){
                                    if (error.response.data.errors.description) {
                                        self.$swal.showValidationMessage(
                                            error.response.data.errors.description[0]
                                          )
                                    }
                                 }
                            })
                        },
                        allowOutsideClick: () => !this.$swal.isLoading()
                    }).then((result) => {})
                }
                if (status == "completed") {
                    this.$refs.myModalRef.show()
                }
            },
            viewReason: function(description){
                this.$swal({
                    width: 600,
                    padding: '3em',
                    text:description
                })
            },
            submitFeedback: function(id, job_id) {
                let review_form = document.getElementById('submit-review-form');
                let form_data = new FormData(review_form);
                form_data.append('freelancer_id', id);
                form_data.append('job_id', job_id);
                var self = this;
                axios.post(APP_URL + '/user/submit-review',form_data)
                .then(function (response) {
                    if(response.data.type == 'success') {
                        var message = response.data.message;
                        self.showMessage(message);
                        setTimeout(function () {
                            self.$refs.myModalRef.hide()
                            window.location.replace(APP_URL+'/employer/dashboard/manage-jobs');
                        }, 1000);
                    } else {
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {});
            },
            submitDispute: function(id) {
                let dispute_form = document.getElementById('dispute-form');
                let form_data = new FormData(dispute_form);
                form_data.append('proposal_id', id);
                var self = this;
                axios.post(APP_URL + '/freelancer/store-dispute',form_data)
                .then(function (response) {
                    console.log(response.data);
                    if(response.data.type == 'success') {
                        var message = response.data.message;
                        self.showMessage(message);
                        setTimeout(function () {
                            window.location.replace(APP_URL+'/freelancer/dashboard');
                        }, 2000);
                    }
                })
                .catch(function (error) {});
            }
         }
    });
}
if (document.getElementById("proposals")) {
    const vproposals = new Vue({
        el: '#proposals',
        mounted: function () { },
        data: { },
        methods: { }
    });
}
if (document.getElementById("packages")) {
    const packages = new Vue({
        el: '#packages',
        mounted: function () {
            if (document.getElementsByClassName("flash_msg") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        created: function() {
            this.getOptions();
        },
        data: {
            user_role:'',
            selected_role:'',
            employer_options:false,
            freelancer_options:false,
            banner_option: false,
            private_chat: false,
            packageID: '',
            package:{
                conneects:'',
                skills:'',
                jobs:'',
                featured_jobs:''
            },
            form_errors:[],
            notificationSystem: {
                options: {
                  success: {
                    position: "topRight",
                    timeout: 3000
                  },
                  error: {
                    position: "topRight",
                    timeout: 4000
                  },
                }
            },
        },
        methods:{
            showMessage(message){
                return this.$toast.success(' ', message, this.notificationSystem.options.success);
            },
            showError(error){
                return this.$toast.error(' ', error, this.notificationSystem.options.error);
            },
            selectedRole: function(role) {
                this.selected_role = role;
                if(role == 2) {
                    this.employer_options = true;
                    this.freelancer_options = false;
                } else if(role == 3) {
                    this.employer_options = false;
                    this.freelancer_options = true;
                }
            },
            submitPackage: function() {
                if(this.selected_role == 3) {
                    if (this.package.conneects, this.package.skills) {
                        this.form_errors = [];
                        jQuery( "#package_form" ).submit();
                    } else {
                        if (!this.package.conneects) this.form_errors.push('connects required');
                        if (!this.package.skills) this.form_errors.push('skills required');
                        this.form_errors.forEach(element => {
                            this.showError(element);
                        });
                    }
                }
                else if(this.selected_role == 2) {
                    if (this.package.jobs, this.package.featured_jobs) {
                        this.form_errors = [];
                        jQuery( "#package_form" ).submit();
                    } else {
                        if (!this.package.jobs) this.form_errors.push('number of jobs required');
                        if (!this.package.featured_jobs) this.form_errors.push('number of featured jobs required');
                        this.form_errors.forEach(element => {
                            this.showError(element);
                        });
                    }
                }
            },
            getOptions: function(){
                let self = this;
                var segment_str = window.location.pathname;
                var segment_array = segment_str.split( '/' );
                var slug = segment_array[segment_array.length - 1];
                if( window.location.pathname == '/admin/packages/edit/'+slug) {
                    axios.post(APP_URL + '/package/get-package-options',{
                        slug: slug
                    })
                    .then(function (response) {
                        console.log(response.data);
                        if (response.data.type == 'success') {
                            if ((response.data.banner_option == 'true')) {
                                self.banner_option = true;
                            } else {
                                self.banner_option = false;
                            }
                            if ((response.data.private_chat == 'true')) {
                                self.private_chat = true;
                            } else {
                                self.private_chat = false;
                            }
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            getPurchasePackage: function(id){
                var self = this;
                axios.get(APP_URL + '/package/get-purchase-package')
                .then(function (response) {
                    if(response.data.type == 'success') {
                        window.location.replace(APP_URL+'/user/package/checkout/'+id);
                    } else if(response.data.type == 'error')  {
                        self.showError(response.data.message);
                    }
                })
                .catch(function (error) {});
            }
        }
    });
}

if (document.getElementById("invoice_list")) {
    new Vue({
        el: '#invoice_list',
        mounted: function () { },
        data: { },
        methods: {
            print: function () {
                const cssText = `
                .wt-transactionhold{
                    float: left;
                    width: 100%;
                }
                .wt-borderheadingvtwo a{font-size: 18px;}
                .wt-transactiondetails{
                    float: left;
                    width: 100%;
                    list-style:none;
                    margin-bottom:20px;
                    line-height: 28px;
                }
                .wt-transactiondetails li{
                    float: left;
                    width: 100%;
                    margin-bottom: 10px;
                    line-height: inherit;
                    list-style-type:none;
                }
                .wt-transactiondetails li:last-child{margin: 0;}
                .wt-transactiondetails li span{
                    font-size: 16px;
                    line-height: inherit;
                }
                .wt-transactiondetails li span.wt-grossamount {float: right;}
                .wt-transactiondetails li span em{
                    font-weight:500;
                    font-style:normal;
                    line-height: inherit;
                }
                .wt-transactionid{
                    margin-left:80px;
                    padding-left:10px;
                    border-left:2px solid #ddd;
                }
                .wt-grossamountusd{font-size: 24px !important;}
                .wt-paymentstatus{
                    color: #21ce93;
                    padding:3px 10px;
                    margin-left:10px;
                    font-size: 14px !important;
                    text-transform: uppercase;
                    border:1px solid #21ce93;
                }
                .wt-createtransactionhold{
                    float: left;
                    width: 100%;
                }
                .wt-createtransactionholdvtwo{
                    padding:0 20px;
                }
                .wt-createtransactionheading{
                    float: left;
                    width: 100%;
                    padding-bottom:15px;
                    border-bottom:1px solid #ddd;
                }
                .wt-createtransactionheading span{
                    display: block;
                    color: #1070c4;
                    font-size: 16px;
                    line-height: 20px;
                }
                .wt-createtransactioncontent{
                    float: left;
                    width: 100%;
                    padding:27px 0;
                    border-bottom: 1px solid #ddd;
                }
                .wt-createtransactioncontent a{
                    padding:0 10px;
                    color: #1070c4;
                    font-size: 14px;
                    line-height: 16px;
                    display: inline-block;
                    vertical-align: middle;
                    border-left:1px solid #ddd;
                }
                .wt-createtransactioncontent a:first-child{
                    border-left:0;
                    padding-left:0;
                }
                .wt-addresshold{
                    float: left;
                    width: 100%;
                    padding:18px 0;
                }
                .wt-addresshold h4{
                    margin: 0;
                    display: block;
                    font-size: 16px;
                    font-weight: 500;
                }
                table.wt-carttable{ margin-bottom:0;}
                table.wt-carttable thead{
                    border:0;
                    font-size:14px;
                    line-height:18px;
                    background: #f5f7fa;
                }
                table.wt-carttable thead tr th{
                    border:0;
                    text-align:left;
                    font-weight: 500;
                    font-weight:normal;
                    padding:20px 4px 20px 160px;
                    font:500 16px/18px 'Montserrat', Arial, Helvetica, sans-serif;
                }
                table.wt-carttable thead tr th + th{
                    text-align:center;
                    padding:20px 4px;
                }
                table.wt-carttable tbody td{
                    width:50%;
                    border:0;
                    font-size:16px;
                    text-align:left;
                    line-height: 20px;
                    display:table-cell;
                    vertical-align:middle;
                    padding:10px 4px 10px 0;
                }
                table.wt-carttable tbody td span,
                table.wt-carttable tbody td img{
                    display:inline-block;
                    vertical-align:middle;
                }
                table.wt-carttable tbody td em{
                    margin: 0;
                    font-size: 16px;
                    line-height: 16px;
                    font-style: normal;
                    vertical-align: middle;
                    display: inline-block;
                }
                table.wt-carttable > thead > tr > th{
                    padding: 6px 20px;
                    width: 25%;
                }
                table.wt-carttable > thead:first-child > tr:first-child > th{
                    border:0;
                    width: 25%;
                    padding: 6px 20px;
                }
                table.wt-carttable tbody td > em{
                    display: block;
                    text-align: center;
                }
                table.wt-carttable tbody td img{
                    width: 116px;
                    height: 116px;
                    margin-right:20px;
                    border-radius:10px;
                }
                table.wt-carttable tbody td + td{
                    width:15%;
                    text-align:center;
                }
                table.wt-carttable tbody td:last-child{
                    width:10%;
                    text-align:right;
                    padding:20px 20px 20px 4px;
                }
                table.wt-carttable tbody td .btn-delete-item{
                    float:right;
                    font-size:24px;
                }
                table.wt-carttable tbody td .btn-delete-item a{color: #fe6767}
                table.wt-carttable tbody td .quantity-sapn{
                    padding:0;
                    width:80px;
                    position:relative;
                    border-radius: 10px;
                    border: 1px solid #e7e7e7;
                }
                table.wt-carttable tbody td .quantity-sapn input[type="text"]{
                    width: 100%;
                    height: 42px;
                    padding: 0 15px;
                    border-radius: 0;
                    box-shadow: none;
                    background: none;
                    line-height: 42px;
                }
                table.wt-carttable tbody td .quantity-sapn input{border:0;}
                table.wt-carttable tbody td .quantity-sapn em{
                    width:10px;
                    display:block;
                    position:absolute;
                    right:10px;
                    cursor:pointer;
                }
                table.wt-carttable tbody td .quantity-sapn em.fa-caret-up{top:8px;}
                table.wt-carttable tbody td .quantity-sapn em.fa-caret-down{ bottom:8px;}
                table.wt-carttable tfoot tr td{ width:50%;}
                table.wt-carttable tbody tr{border-bottom: 1px solid #ddd;}
                table.wt-carttable tbody tr:last-child{border-bottom:0; }
                table.wt-carttablevtwo tbody td > em{
                    color: #636c77;
                    font-weight:500;
                    text-align: left;
                    display: inline-block;
                }
                table.wt-carttablevtwo tbody td > span{
                    float: right;
                }
                table.wt-carttablevtwo tbody td{padding:20px;}

                .wt-refundscontent{
                    float: left;
                    width: 100%;
                }
                .wt-refundsdetails{
                    float: left;
                    width: 100%;
                    list-style:none;
                }
                .wt-refundsdetails li{
                    float: left;
                    width: 100%;
                    padding:15px 0;
                    list-style-type:none;
                }
                .wt-refundsdetails li + li{border-top: 1px solid #ddd;}
                .wt-refundsdetails li strong{
                    width: 300px;
                    float:left;
                }
                .wt-refundsdetails li .wt-rightarea{float: left;}
                .wt-refundsdetails li .wt-rightarea span{
                    display: block;
                }
                .wt-refundsdetails li .wt-rightarea em{
                    font-weight:500;
                    font-style: normal;
                }
                .wt-refundsdetails li:nth-child(3){
                    border:0;
                    padding-top:0;
                }
                .wt-refundsinfo{
                        width:100%;
                        clear:both;
                    display: block;
                }
                table.wt-carttable tbody tr:nth-child(6){border:0;}
                table.wt-carttablevtwo tbody tr:nth-child(6) td{padding: 20px 20px 0px;}
              `
                const d = new Printd()
                d.print(document.getElementById('printable_area'), cssText)
            }
        }
    });
}
