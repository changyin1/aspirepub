/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });

$(function () {
    //date picker
    $('.datepicker').flatpickr();
    $('.datepicker-time').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
        }
    });
    $("input").change(function () {
        if (!$(this).hasClass('no-anim')) {
            "" != $(this).val() ? $(this).parent().addClass("filled") : $(this).parent().removeClass("filled");
        }
    });

    $("input").each(function () {
        if (!$(this).hasClass('no-anim')) {
            "" != $(this).val() ? $(this).parent().addClass("filled") : $(this).parent().removeClass("filled");
        }
    });

    $('.unmask').on('mousedown', function () {
        var $input = $(this).next('input')[0];
        if ($input.type == "password") {
            $input.type = "text";
            console.log('test');
        } else {
            $input.type = "password";
        }
    }).on('mouseup', function () {
        var $input = $(this).next('input')[0];
        $input.type = "password";
    });

    $('form-group select').each(function () {
        var placeholder = $(this).data('placeholder');
        if ($(this).hasClass('city')) {
            $(this).select2({
                minimumResultsForSearch: Infinity,
                placeholder: placeholder,
                ajax: {
                    type: 'post',
                    url: $('#city-url').val(),
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
        } else if ($(this).hasClass('specialists')) {
            $(this).select2({
                minimumResultsForSearch: Infinity,
                placeholder: placeholder,
                ajax: {
                    type: 'post',
                    url: $('#availability-url').val(),
                    data: function () {
                        return {
                            week: $('#week-select').val(), schedule: $('#schedule-id').val()
                        };
                    },
                    cache: true
                },
                language: {
                    noResults: function (params) {
                        return "No Available Specialists Found";
                    }
                }
            });
        } else if ($(this).hasClass('searchable')) {
            $(this).select2({
                placeholder: placeholder,
                matcher: matchCustom
            });
        } else if ($(this).hasClass('noclear')) {
            $(this).select2({
                minimumResultsForSearch: Infinity,
                placeholder: placeholder,
            });
        } else {
            $(this).select2({
                minimumResultsForSearch: Infinity,
                placeholder: placeholder,
                allowClear: true
            });
        }
    });

    function matchCustom(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
            //check filters
            if ($('.client').val() && $('.client').val() !== " ") {
                if (!data.element.attributes.client || data.element.attributes.client.value != $('.client').val()) {
                    return null;
                }
            }
            if ($('.company').val() && $('.company').val() !== " ") {
                if (!data.element.attributes.company || data.element.attributes.company.value != $('.company').val()) {
                    return null;
                }
            }
            if ($('.region').val() && $('.region').val() !== " ") {
                if (!data.element.attributes.region || data.element.attributes.region.value != $('.region').val()) {
                    return null;
                }
            }
            return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
            return null;
        }

        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (data.text.indexOf(params.term) > -1) {
            //check filters
            if ($('.client').val() && $('.client').val() !== " ") {
                if (!data.element.attributes.client || data.element.attributes.client.value != $('.client').val()) {
                    return null;
                }
            }
            if ($('.company').val() && $('.company').val() !== " ") {
                if (!data.element.attributes.company || data.element.attributes.company.value != $('.company').val()) {
                    return null;
                }
            }
            if ($('.region').val() && $('.region').val() !== " ") {
                if (!data.element.attributes.region || data.element.attributes.region.value != $('.region').val()) {
                    return null;
                }
            }

            var modifiedData = $.extend({}, data, true);

            // You can return modified objects from here
            // This includes matching the `children` how you want in nested data sets
            return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    //calendar js
    $('#calendar').fullCalendar({
        dayRender: function (date, cell) {
            cell.attr('data-week', getWeek(date.date()));
            var data = {
                'userID': $('#user-id').val(),
                'date': date.format(),
                'week': getWeek(date.date()),
            };
            if (date.date() % 7 == 1) {
                $.ajax({
                    type: "GET",
                    url: $('#availability-url').val(),
                    data: data,
                    beforeSend: function () {
                        cell.children('div').remove();
                        cell.append('<div class="loader">Loading...</div>');
                    },
                    success: function (response) {
                        cell.children('div').remove();
                        if (response.available) {
                            $('.fc-day[data-week="' + response.week + '"]').addClass('available');
                            cell.html('<span>Max Calls: ' + response.max + '</span>')
                        }
                    },
                    error: function () {
                        cell.children('div').remove();
                        cell.append('<div class="alert alert-danger">Error Retrieving Day Info Please Try Again Later</div>');
                    }
                });
            }
        },
        dayClick: function (date) {
            if (date.format() < moment().format()) {
                return false;
            }
            ;
            if (IsDateHasEvent(date)) {
                console.log('has event');
                return false;
            }
            var data = {
                'date': date.format(),
                'userID': $('#user-id').val(),
                'available': 1,
                'max': $('#max').val()
            };
            var $day = $(this);
            $.ajax({
                type: "POST",
                url: $('#availability-url').val(),
                data: data,
                beforeSend: function () {
                    $day.children('div').remove();
                    $day.append('<div class="loader">Loading...</div>');
                },
                success: function (response) {
                    $day.children('div').remove();
                    if (response.success) {
                        if (response.available == 1) {
                            $day.addClass('available');
                            console.log($('.fc-day[data-week="' + response.week + '"]'));
                            $('.fc-day[data-week="' + response.week + '"]').addClass('available');
                            $day.html('<span>Max Calls: ' + response.max + '</span>');
                        } else {
                            $day.removeClass('available');
                            $('.fc-day[data-week="' + response.week + '"]').removeClass('available');
                            $('.fc-day[data-week="' + response.week + '"]:first').html('');
                        }
                    } else {
                        $day.append('<div class="alert alert-danger">Error Submitting Please Try Again Later</div>');
                    }
                },
                error: function () {
                    $day.children('div').remove();
                    $day.append('<div class="alert alert-danger">Error Submitting Please Try Again Later</div>');
                }
            });
        },
        header: {
            left: 'prev,next title',
            center: '',
            right: 'today '
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

    function getWeek(date) {
        return Math.ceil(date / 7);
    }

    //Question list
    $('.question-item').click(function () {
        $(this).toggleClass('active');
    })

    //Table row linking
    $('.link-row').click(function () {
        if (!$(this).hasClass('checkbox')) {
            window.location = $(this).data("href");
        }
    })

    // sortable
    $("#sortable tbody").sortable({
        update: function (event, ui) {
            var data = {};
            $('#sortable tbody tr').each(function () {
                data[$(this).data('id')] = $(this).index()
            });
            $.ajax({
                type: "POST",
                url: $('#sortable').data('sort-url'),
                data: data,
                beforeSend: function () {
                    $('.question-list').children('div').remove();
                    $('.question-list').addClass('loading');
                    $('.question-list').append('<div class="loader">Loading...</div>');
                },
                success: function (response) {
                    $('.question-list').removeClass('loading');
                    $('.question-list').children('div').remove();
                    $.each(response.templateQuestions, function (i, question) {
                        console.log(question);
                        console.log(question.id);
                        console.log(question.order);
                        $('tr[data-id="' + question.id + '"]').find('.order').html(question.order);
                    })
                },
                error: function () {
                    $('.question-list').removeClass('loading');
                    $('.question-list').children('div').remove();
                    $('.question-list').append('<div class="error"></div>');
                    $('.error').html('Error Saving Question Order');
                }
            });
        }
    });
    $("#sortable tbody").disableSelection();

    //handle modal form submissions
    $('.modal form').submit(function (e) {
        e.preventDefault();
        let self = $(this);
        let url = $(this).attr('action');
        let data = $(this).serializeArray();
        if (self.hasClass('duplicate-form') && $('#schedule_id').val() == 'null') {
            var schedules = [];
            $.each($("input[name='schedule-id']:checked"), function(){
                schedules.push($(this).val());
            });
            data.push({name: 'schedule_id', value: schedules});
        }
        self.find('.errors').html('');
        self.find('.btn-submit').attr('disabled', true).html('Submitting');
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (response) {
                if (response.success) {
                    self.closest('.modal').modal('hide');
                    self.find('.btn-submit').attr('disabled', false);
                    // $('#successModal').modal('show');
                    if (response.redirect) {
                        $('body').append('<input type="hidden" id="redirect" value="'+ response.redirect + '">')
                    }
                    if ($('#redirect').val()) {
                        window.location.replace($('#redirect').val());
                    } else {
                        location.reload();
                    }
                } else {
                    self.find('.btn-submit').attr('disabled', false).html('Submit');
                    self.find('.errors').append('<div class="alert alert-danger">Error submitting. Please try again later.</div>')
                }
            },
            error: function (response) {
                $.each(response.responseJSON.errors, function (e, error) {
                    self.find('.errors').append('<div class="alert alert-danger">' + error[0] + '</div>')
                });
                self.find('.btn-submit').attr('disabled', false).html('Submit');
            }
        });
    });

    //refresh on success modal
    $('#successModal .btn-primary').click(function (e) {
        if ($('#redirect').val()) {
            window.location.replace($('#redirect').val());
        } else {
            location.reload();
        }
    });

    //handle ajax forms
    $('form.ajax').submit(function(e) {
        e.preventDefault();
        let self = $(this);
        let url = $(this).attr('action');
        let data = $(this).serializeArray();
        if (self.hasClass('assign-form')) {
            var calls = [];
            $.each($("input[name='call-id']:checked"), function(){
                calls.push($(this).val());
            });
            data.push({name: 'calls', value: calls});
            data.push({name: 'type', value: self.data('type')});
        }
        self.find('.errors').html('');
        self.find('.btn').attr('disabled', true);
        self.find('.btn-submit').val('Submitting');
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (response) {
                if (response.success) {
                    self.find('.btn-submit').attr('disabled', false);
                    if ($('#redirect').val()) {
                        window.location.replace($('#redirect').val());
                    } else {
                        location.reload();
                    }
                } else {
                    self.find('.btn-submit').attr('disabled', false).val('Submit');
                    self.find('.errors').append('<div class="alert alert-danger">Error submitting. Please try again later.</div>')
                }
            },
            error: function (response) {
                $.each(response.responseJSON.errors, function (e, error) {
                    self.find('.errors').append('<div class="alert alert-danger">' + error[0] + '</div>')
                });
                self.find('.btn-submit').attr('disabled', false).val('Submit');
            }
        });
    });

    //initialize data table
    function dataTable(element) {
        let searchable = $(element).data('searchable') == null ? false :  $(element).data('searchable');
        $(element).DataTable({
            searching: searchable,
            stateSave: true,
            fixedHeader: true
        });
    }

    $('.submit-alert').click(function(e) {
        if (confirm($(this).data('message'))) {
            $('#' + $(this).data('field')).val(1);
        } else {
            e.preventDefault();
        };
    });

    dataTable('table.data-table');

    //handle dataTable showing;
    function toggleTable(select) {
        $('table.hidden').each(function() {
            $(this).parents('div.dataTables_wrapper').first().hide();
        });
        let week = $(select).val();
        $('table[data-week="' + week + '"]').parents('div.dataTables_wrapper').first().show();
    }

    toggleTable($('#week-select'));
    $('#week-select').on('change', function() {
        toggleTable($('#week-select'));
        $('.specialists').val(null).trigger('change');
    });

    //checkbox handling
    $(".checkbox-all").click(function () {
        $(this).closest('table').find('.checkbox').prop('checked', $(this).prop('checked'));
    });

    $(".checkbox-row").click(function (e) {
        if(event.target.nodeName.toLowerCase() !== 'input' ) {
            $(this).find('.checkbox').prop('checked', !$(this).find('.checkbox').prop('checked'))
        }
    });

    $('.removeQuestionFromTemplate').click(function(e) {
        $('input[name="question"]').val($(this).data('question'));
    });

    $('#viewCustomAgentModal').on('click', '.btn-add', function(e) {
        e.preventDefault();
        var form = $(this).parents('form');
        var currentEntry = form.find('.form-group:last');
        var newEntry = $(currentEntry.clone()).appendTo($(this).parents('.modal-body'));
        newEntry.find('input').val('');
        form.find('.form-group:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('-');
    }).on('click', '.btn-remove', function(e) {
        e.preventDefault();
        $(this).parents('.form-group').remove();
        return false;
    }).on('click', '.btn-remove-agent', function(e) {
        e.preventDefault();

        if (confirm('Removing agent, are you sure?')) {
            let form = $(this).parents('form')
            form.find('.errors').html('');
            let url = form.attr('action');
            let data = {
                'type': 'remove',
                'id': $(this).parents('.agent-item').data('agentid')
            };
            let self = $(this);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    if (response.success) {
                        self.parents('.form-group').remove();
                    } else {
                        self.parents('form').find('.errors').append('<div class="alert alert-danger">Error submitting. Please try again later.</div>')
                    }
                },
                error: function (response) {
                    $.each(response.responseJSON.errors, function (e, error) {
                        self.parents('form').find('.errors').append('<div class="alert alert-danger">' + error[0] + '</div>')
                    });
                }
            });
        }
    });
});