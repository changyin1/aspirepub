
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
        dayRender: function(date, cell) {
            var data = {
                'userID': $('#user-id').val(),
                'date': date.format()
            };
            $.ajax({
                type: "GET",
                url: "api/availability",
                data: data,
                beforeSend: function () {
                    cell.children('div').remove();
                    cell.append('<div class="loader">Loading...</div>');
                },
                success: function(response) {
                    cell.children('div').remove();
                    if (response.available) {
                        console.log(cell);
                        cell.addClass('available');
                    }
                },
                error: function() {
                    cell.children('div').remove();
                    cell.append('<div class="alert alert-danger">Error Retrieving Day Info Please Try Again Later</div>');
                }
            });
        },
        dayClick: function(date) {
            if (date.format() < moment().format()) {
                return false;
            };
            if (IsDateHasEvent(date)) {
                console.log('has event');
                return false;
            }
            var data = {
                'date': date.format(),
                'userID': $('#user-id').val(),
                'available': 1
            };
            var $day = $(this);
            $.ajax({
                type: "POST",
                url: "api/availability",
                data: data,
                beforeSend: function () {
                    $day.children('div').remove();
                    $day.append('<div class="loader">Loading...</div>');
                },
                success: function(response) {
                    $day.children('div').remove();
                    if (response.success) {
                        if(response.available == 1) {
                            $day.addClass('available');
                        } else {
                            $day.removeClass('available');
                        }                        
                    } else {
                        $day.append('<div class="alert alert-danger">Error Submitting Please Try Again Later</div>');
                    }
                },
                error: function() {
                    $day.children('div').remove();
                    $day.append('<div class="alert alert-danger">Error Submitting Please Try Again Later</div>');
                }
            });
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
    function IsDateHasEvent(date) {
        var allEvents = [];
        allEvents = $('#calendar').fullCalendar('clientEvents');
        var event = $.grep(allEvents, function (v) {
            return +v.start === +date;
        });
        return event.length > 0;
    }
});