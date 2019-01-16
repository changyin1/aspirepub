
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

$(function() {
    $("input").change(function() {
        "" != $(this).val() ? $(this).parent().addClass("filled") : $(this).parent().removeClass("filled")
    }),
    $("input").each(function() {
        "" != $(this).val() ? $(this).parent().addClass("filled") : $(this).parent().removeClass("filled")
    })
    $('.unmask').on('mousedown', function() {
        var $input = $(this).next('input')[0];
        if ($input.type == "password") {
            $input.type = "text";
            console.log('test');
        } else {
            $input.type = "password";
        }
    }).on('mouseup', function() {
        var $input = $(this).next('input')[0];
        $input.type = "password";
    });

    $('select').each(function () {
        var placeholder = $(this).data('placeholder');
        if ($(this).hasClass('city')) {
            $(this).select2({
                minimumResultsForSearch: Infinity,
                placeholder: placeholder,
                ajax: {
                    type: 'post',
                    url: 'api/cities',
                    data: function () {
                        return {
                            state: $('select.state').val()
                        };
                    },
                    cache: true
                },
                language: {
                    noResults: function (params) {
                        return "Please Select a State.";
                    }
                }
            });
        } else {
            $(this).select2({
                minimumResultsForSearch: Infinity,
                placeholder: placeholder
            });
        }
    });

    //calendar js
    $('#calendar').fullCalendar({
        events: [
            {
                title  : 'event1',
                start  : '2019-01-01'
            },
            {
                title  : 'event2',
                start  : '2019-01-05'
            },
            {
                title  : 'event3',
                start  : '2019-01-21',
            }
        ],
        dayClick: function(date) {
            $('.date').html(date.format('MMM DD, YYYY'));
            $('#date').val(date.format());
            $('#availability-modal').modal();
        },
        eventClick: function(calEvent, jsEvent, view) {
            if (calEvent.start.format() < moment().format()) {
                return false;
            };
            $('.date').html(calEvent.start.format('MMM DD, YYYY'));
            $('#date').val(calEvent.start.format());
            $('#availability-modal').modal();
        },
        header: {
            left:   'prev,next title',
            center: '',
            right:  'today '
        },
        buttonText: {
            today: 'Today',
        }
    });
    $('#availability-modal').on('hidden.bs.modal', function () {
        // clear errors
      $('#form-error').html('');
    });
    $('#submit-availability-btn').on('click', function(e) {
        e.preventDefault();
        console.log($('form.availabilty-form').serialize())
        $.ajax({
            type: "POST",
            url: "api/availability",
            data: $('form.availabilty-form').serialize(),
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    $('#availability-modal').modal('hide');
                } else {
                    $('#form-error').html('<div class="alert alert-danger">Error Submitting Please Try Again Later</div>');
                }
            },
            error: function() {
                alert('Error');
            }
        });
    return false;
    });
});