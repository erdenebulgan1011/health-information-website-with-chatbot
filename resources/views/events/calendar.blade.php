 @extends('layouts.ForumApp')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Үйл явдлын хуваарь</h3>
                    <div>
                        <a href="{{ route('events.index') }}" class="btn btn-light btn-sm mr-2">
                            <i class="fas fa-list"></i> Жагсаалт харах
                        </a>
                        <button id="printBtn" class="btn btn-light btn-sm">
                            <i class="fas fa-print"></i> Хэвлэх
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" id="eventSearch" class="form-control" placeholder="Хайх...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-filter"></i>
                                    </span>
                                </div>
                                <select id="locationFilter" class="form-control">
                                    <option value="">Бүх байршил</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary" id="todayBtn">Өнөөдөр</button>
                                <button type="button" class="btn btn-outline-secondary" id="monthViewBtn">Сар</button>
                                <button type="button" class="btn btn-outline-secondary" id="weekViewBtn">Долоо хоног</button>
                                <button type="button" class="btn btn-outline-secondary" id="dayViewBtn">Өдөр</button>
                            </div>
                        </div>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>


        <!-- Upcoming Events -->
<!-- Upcoming Events -->
<div class="col-md-6 mb-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-calendar-plus mr-2"></i>Удахгүй болох үйл явдлууд</h5>
        </div>
        <div class="card-body">
            <div class="upcoming-events-list">
                @if(count($upcomingEvents) > 0)
                @foreach($upcomingEvents as $event)
                @php
                    // Parse start/end times
                    $start = \Carbon\Carbon::parse($event->start_time);
                    $end   = \Carbon\Carbon::parse($event->end_time ?? $start->copy()->addHour());

                    // Build the Google Calendar “Add to calendar” URL
                    $googleCalUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                        .'&text='     . urlencode($event->title)
                        .'&dates='    . $start->format('Ymd\THis') . '/' . $end->format('Ymd\THis')
                        .'&details='  . urlencode($event->description ?? '')
                        .'&location=' . urlencode($event->location ?? '');
                @endphp

                <div class="media mb-3 pb-3 border-bottom">
                  <div class="event-date text-center mr-3 bg-light p-2 rounded">
                    <h5 class="mb-0">{{ $start->format('d') }}</h5>
                    <small>{{ $start->format('M') }}</small>
                  </div>
                  <div class="media-body">
                    <h5 class="mt-0">
                      <a href="#"
                         class="event-link text-primary"
                         data-id="{{ $event->id }}">
                        {{ $event->title }}
                      </a>
                      @if($event->is_featured)
                        <span class="badge badge-warning ml-2">Онцлох</span>
                      @endif
                    </h5>
                    <div class="small text-muted">
                      <i class="fas fa-clock mr-1"></i>
                        {{ $start->format('H:i') }} – {{ $end->format('H:i') }}
                      <span class="mx-2">|</span>
                      <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ $event->location ?: 'Тодорхойгүй' }}
                    </div>

                    @if(auth()->check())
                      <div class="mt-2 d-flex">
                        {{-- Use the PHP-built variable here --}}
                        <a href="{{ $googleCalUrl }}"
                           target="_blank"
                           class="btn btn-success btn-sm mr-2">
                          <i class="fas fa-calendar-plus"></i> Миний календарт нэмэх
                        </a>

                        @if($event->url)
                          <a href="{{ $event->url }}"
                             target="_blank"
                             class="btn btn-primary btn-sm">
                            <i class="fas fa-link"></i> Холбоосоор орох
                          </a>
                        @endif
                      </div>
                    @endif
                  </div>
                </div>
            @endforeach
                                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p>Удахгүй болох үйл явдал байхгүй байна.</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('events.calendar') }}" class="btn btn-sm btn-outline-success">Бүгдийг харах</a>
        </div>
    </div>
</div>

 <!-- Reminder Modal -->
 <div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="reminderModalLabel">Сануулга тохируулах</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reminderForm">
                    <input type="hidden" id="reminderEventId" name="event_id" value="">
                    <div class="form-group">
                        <label for="reminderType">Сануулах арга:</label>
                        <select class="form-control" id="reminderType" name="reminder_type">
                            <option value="email">И-мэйл</option>
                            <option value="sms">SMS</option>
                            <option value="both">И-мэйл болон SMS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reminderTime">Хэдэн цагийн өмнөөс сануулах:</label>
                        <select class="form-control" id="reminderTime" name="reminder_time">
                            <option value="15">15 минут</option>
                            <option value="30">30 минут</option>
                            <option value="60">1 цаг</option>
                            <option value="120">2 цаг</option>
                            <option value="720">12 цаг</option>
                            <option value="1440" selected>24 цаг</option>
                            <option value="2880">2 өдөр</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
                <button type="button" class="btn btn-warning" id="saveReminderBtn">Хадгалах</button>
            </div>
        </div>
    </div>
</div>
    <!-- Featured Events -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-star mr-2"></i>Онцлох үйл явдлууд</h5>
            </div>
            <div class="card-body">
                <div id="featuredEventsCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($featuredEvents as $index => $event)
                            <li data-target="#featuredEventsCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($featuredEvents as $index => $event)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="featured-event-card">
                                    <div class="featured-event-image" style="background-image: url('{{ $event->image_url ?: asset('images/event-placeholder.jpg') }}')">
                                        <div class="featured-event-date">
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <div class="featured-event-content p-3">
                                        <h4 class="mb-2">{{ $event->title }}</h4>
                                        <p class="mb-2 text-muted">
                                            <i class="fas fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                            <br>
                                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $event->location ?: 'Тодорхойгүй' }}
                                        </p>
                                        <p class="event-description">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-sm btn-primary event-link" data-id="{{ $event->id }}">Дэлгэрэнгүй</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#featuredEventsCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#featuredEventsCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>


    </div>

    <!-- Event Details Modal -->
    <!-- Event Details Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="eventModalLabel">Үйл явдлын дэлгэрэнгүй</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="event-info">
                        <div id="eventImage" class="mb-3 text-center">
                            <!-- Event image will be loaded here -->
                        </div>

                        <h4 id="eventTitle" class="mb-3"></h4>

                        <div class="row mb-3">
                            <div class="col-md-1 text-center">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <div class="col-md-11">
                                <strong>Хугацаа:</strong>
                                <div id="eventTime"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-1 text-center">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                            </div>
                            <div class="col-md-11">
                                <strong>Байршил:</strong>
                                <div id="eventLocation"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-1 text-center">
                                <i class="fas fa-tag text-info"></i>
                            </div>
                            <div class="col-md-11">
                                <strong>Ангилал:</strong>
                                <div id="eventCategory"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-1 text-center">
                                <i class="fas fa-users text-success"></i>
                            </div>
                            <div class="col-md-11">
                                <strong>Оролцогчид:</strong>
                                <div id="eventAttendees"></div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div id="attendeeProgress" class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small id="attendeeCount" class="text-muted"></small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-1 text-center">
                                <i class="fas fa-align-left text-info"></i>
                            </div>
                            <div class="col-md-11">
                                <strong>Тайлбар:</strong>
                                <div id="eventDescription" class="mt-2"></div>
                            </div>
                        </div>

                        <div class="row mb-3" id="urlRow">
                            <div class="col-md-1 text-center">
                                <i class="fas fa-link text-success"></i>
                            </div>
                            <div class="col-md-11">
                                <strong>Холбоос:</strong>
                                <div id="eventUrl"></div>
                            </div>
                        </div>

                        <div class="row mb-3" id="materialsRow">
                            <div class="col-md-1 text-center">
                                <i class="fas fa-file-alt text-warning"></i>
                            </div>
                            <div class="col-md-11">
                                <strong>Материалууд:</strong>
                                <div id="eventMaterials"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments section -->
                    <div class="event-comments mt-4 pt-4 border-top" id="commentsSection">
                        <h5><i class="fas fa-comments mr-2"></i>Сэтгэгдэл</h5>
                        <div id="commentsList">
                            <!-- Comments will be loaded here -->
                        </div>

                        @if(auth()->check())
                            <div class="add-comment mt-3">
                                <form id="commentForm">
                                    <input type="hidden" id="eventId" name="event_id" value="">
                                    <div class="form-group">
                                        <textarea class="form-control" id="commentContent" name="content" rows="2" placeholder="Сэтгэгдэл бичих..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Илгээх</button>
                                </form>
                            </div>
                        @else
                            <div class="text-center p-3 bg-light rounded">
                                <p class="mb-0">Сэтгэгдэл үлдээхийн тулд <a href="{{ route('login') }}">Нэвтэрнэ үү</a></p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    @if(auth()->check())
                        <div class="mr-auto">
                            {{-- <button id="attendBtn" class="btn btn-success" data-id="">
                                <i class="fas fa-user-plus"></i> Оролцох
                            </button> --}}
                            <button id="reminderBtn" class="btn btn-warning" data-id="">
                                <i class="fas fa-bell"></i> Сануулга
                            </button>
                            <button id="shareBtn" class="btn btn-info" data-id="">
                                <i class="fas fa-share-alt"></i> Хуваалцах
                            </button>
                        </div>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
                    <a id="eventUrlBtn" href="#" target="_blank" class="btn btn-primary">Холбоосоор орох</a>
                    <a id="addToCalendarBtn" href="#" class="btn btn-success">Миний календарт нэмэх</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="shareModalLabel">Үйл явдлыг хуваалцах</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shareLink">Холбоос:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="shareLink" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="copyLinkBtn">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="social-share-buttons text-center mt-4">
                        <button class="btn btn-primary mx-1" id="shareFacebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </button>
                        <button class="btn btn-info mx-1" id="shareTwitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </button>
                        <button class="btn btn-success mx-1" id="shareWhatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </button>
                        <button class="btn btn-danger mx-1" id="shareEmail">
                            <i class="fas fa-envelope"></i> Email
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS for modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<!-- Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!-- FullCalendar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<!-- Custom styles -->
<style>
    .fc-event {
        cursor: pointer;
        border-radius: 4px;
        border: none;
        padding: 3px;
        margin-bottom: 2px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .fc-event:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .fc-day-grid-event .fc-content {
        white-space: normal;
        overflow: hidden;
        padding: 2px 4px;
    }

    .fc-title {
        font-weight: 500;
    }

    .fc-today {
        background-color: rgba(66, 139, 202, 0.1) !important;
    }

    .fc-day-header {
        background-color: #f8f9fa;
        padding: 10px 0 !important;
        font-weight: 600;
    }

    .fc-day-number {
        font-size: 1.1em;
        font-weight: 500;
        padding: 8px !important;
    }

    .fc button {
        height: auto;
        padding: 6px 12px;
    }

    #calendar {
        min-height: 650px;
    }

    .event-info i {
        font-size: 1.2rem;
    }

    @media print {
        .no-print {
            display: none;
        }

        #calendar {
            max-width: 100%;
            max-height: 100%;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize location filter
        const locations = new Set();

        // Initialize calendar
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            themeSystem: 'bootstrap4',
            bootstrapFontAwesome: {
                prev: 'fa-chevron-left',
                next: 'fa-chevron-right',
                prevYear: 'fa-angle-double-left',
                nextYear: 'fa-angle-double-right'
            },
            events: '/api/events',
            eventRender: function(event, element, view) {
                // Add location to filter options
                if (event.location && event.location.trim() !== '') {
                    locations.add(event.location);
                }

                // Apply search filter
                const searchTerm = $('#eventSearch').val().toLowerCase();
                if (searchTerm &&
                    event.title.toLowerCase().indexOf(searchTerm) === -1 &&
                    (event.description || '').toLowerCase().indexOf(searchTerm) === -1 &&
                    (event.location || '').toLowerCase().indexOf(searchTerm) === -1) {
                    return false;
                }

                // Apply location filter
                const locationFilter = $('#locationFilter').val();
                if (locationFilter && event.location !== locationFilter) {
                    return false;
                }

                // Add tooltip
                element.attr('title', event.title);

                // Add visible timestamp to day view
                if (view.name === 'agendaDay' || view.name === 'agendaWeek') {
                    element.find('.fc-time').css('display', 'block');
                }

                // Add location to event title in month view if there's space
                if (view.name === 'month' && event.location) {
                    const content = element.find('.fc-content');
                    content.append('<div class="fc-location"><i class="fas fa-map-marker-alt"></i> ' + event.location + '</div>');
                }

                // Customize event colors based on some criteria
                const colors = {
                    'dlkfnvs': '#3788d8',
                    'dnvir': '#28a745',
                    'default': '#fd7e14'
                };

                element.css('background-color', colors[event.location] || colors.default);

                return true;
            },
            eventClick: function(event) {
                // Populate modal with event details
                $('#eventTitle').text(event.title);
        $('#eventTime').text(moment(event.start).format('YYYY-MM-DD HH:mm') + ' - ' +
            (event.end ? moment(event.end).format('YYYY-MM-DD HH:mm') : 'N/A'));
        $('#eventLocation').text(event.location || 'Тодорхойгүй');
        $('#eventDescription').text(event.description || 'Тайлбар байхгүй');
        $('#eventCategory').text(event.category || 'Ангилал байхгүй');

        if (event.url) {
            $('#eventUrl').html('<a href="' + event.url + '" target="_blank">' + event.url + '</a>');
            $('#eventUrlBtn').attr('href', event.url).show();
            $('#urlRow').show();
        } else {
            $('#eventUrl').text('Холбоос байхгүй');
            $('#eventUrlBtn').hide();
            $('#urlRow').hide();
        }
    // Set button data attributes
    $('#attendBtn').data('id', event.id);
        $('#reminderBtn').data('id', event.id);
        $('#shareBtn').data('id', event.id);
        $('#reminderEventId').val(event.id);
                // Generate Google Calendar URL
                const googleCalUrl = 'https://calendar.google.com/calendar/render?' +
                    'action=TEMPLATE' +
                    '&text=' + encodeURIComponent(event.title) +
                    '&dates=' + moment(event.start).format('YYYYMMDD[T]HHmmss') + '/' +
                    moment(event.end || moment(event.start).add(1, 'hours')).format('YYYYMMDD[T]HHmmss') +
                    '&details=' + encodeURIComponent(event.description || '') +
                    '&location=' + encodeURIComponent(event.location || '') +
                    '&sprop=&sprop=name:';

                $('#addToCalendarBtn').attr('href', googleCalUrl);

                // Show modal
                $('#eventModal').modal('show');

                // Prevent navigation if it's a URL
                return false;
            },
            dayClick: function(date) {
                // Optionally, you could add functionality for clicking on a day
                console.log('Day clicked:', date.format());
            },
            viewRender: function(view) {
                // Update active button based on current view
                $('.btn-group .btn').removeClass('active');
                if (view.name === 'month') {
                    $('#monthViewBtn').addClass('active');
                } else if (view.name === 'agendaWeek') {
                    $('#weekViewBtn').addClass('active');
                } else if (view.name === 'agendaDay') {
                    $('#dayViewBtn').addClass('active');
                }
            },
            // More calendar options
            timeFormat: 'H:mm',
            slotLabelFormat: 'H:mm',
            allDaySlot: true,
            allDayText: 'Бүх өдөр',
            slotDuration: '00:30:00',
            slotLabelInterval: '01:00',
            firstDay: 1, // Monday as first day
            height: 'auto',
            aspectRatio: 1.8,
            eventLimit: true,
            views: {
                month: {
                    eventLimit: 4 // Show "more" link when more than 4 events
                }
            }
        });


    // 1) Build a lookup of all upcoming events (keep this at top of your <script>)
        const upcomingMap = {};
    @foreach($upcomingEvents as $event)
      upcomingMap[{{ $event->id }}] = @json($event);
    @endforeach

    // 2) Delegate title‐clicks to populate & show the modal immediately
    $(document).on('click', '.upcoming-events-list .event-link', function(e) {
      e.preventDefault();

      const id = $(this).data('id');
      const ev = upcomingMap[id];
      if (!ev) {
        return console.error('No upcoming-event data for ID', id);
      }

      // Populate modal fields exactly as your calendar’s eventClick does:
      $('#eventTitle').text(ev.title);
      $('#eventTime').text(
        moment(ev.start_time).format('YYYY-MM-DD HH:mm') +
        ' – ' +
        (ev.end_time
           ? moment(ev.end_time).format('YYYY-MM-DD HH:mm')
           : 'N/A')
      );
      $('#eventLocation').text(ev.location || 'Тодорхойгүй');
      $('#eventCategory').text(ev.category || 'Ангилал байхгүй');
      $('#eventDescription').text(ev.description || 'Тайлбар байхгүй');

      // URL row
      if (ev.url) {
        $('#eventUrl')
          .html(`<a href="${ev.url}" target="_blank">${ev.url}</a>`);
        $('#eventUrlBtn').attr('href', ev.url).show();
        $('#urlRow').show();
      } else {
        $('#eventUrlBtn').hide();
        $('#urlRow').hide();
      }

      // Rebuild the “Add to Calendar” link
      const start = moment(ev.start_time);
      const end   = moment(ev.end_time || start.clone().add(1, 'hours'));
      const calUrl = 'https://calendar.google.com/calendar/render?' +
        'action=TEMPLATE' +
        '&text='     + encodeURIComponent(ev.title) +
        '&dates='    + start.format('YYYYMMDD[T]HHmmss') + '/' + end.format('YYYYMMDD[T]HHmmss') +
        '&details='  + encodeURIComponent(ev.description || '') +
        '&location=' + encodeURIComponent(ev.location || '');
      $('#addToCalendarBtn').attr('href', calUrl);

      // Finally show the modal
      $('#eventModal').modal('show');
    });





        // Populate location filter after events are loaded
        setTimeout(function() {
            const locationSelect = $('#locationFilter');
            locations.forEach(function(location) {
                locationSelect.append($('<option>', {
                    value: location,
                    text: location
                }));
            });
        }, 1000);

        // Event search functionality
        $('#eventSearch').on('keyup', function() {
            $('#calendar').fullCalendar('rerenderEvents');
        });

        // Location filter functionality
        $('#locationFilter').on('change', function() {
            $('#calendar').fullCalendar('rerenderEvents');
        });

        // View buttons
        $('#todayBtn').on('click', function() {
            $('#calendar').fullCalendar('today');
        });

        $('#monthViewBtn').on('click', function() {
            $('#calendar').fullCalendar('changeView', 'month');
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#weekViewBtn').on('click', function() {
            $('#calendar').fullCalendar('changeView', 'agendaWeek');
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#dayViewBtn').on('click', function() {
            $('#calendar').fullCalendar('changeView', 'agendaDay');
            $(this).addClass('active').siblings().removeClass('active');
        });

        // Print functionality
        $('#printBtn').on('click', function() {
            window.print();
        });
    });




    // Event modal button handlers
    $('#eventModal').on('shown.bs.modal', function() {
            // Get the event ID from the buttons
            const eventId = $('#attendBtn').data('id');

            // Setup modal close button
            $('.close, button[data-dismiss="modal"]').on('click', function() {
                $('#eventModal').modal('hide');
            });

            // Attend button handler
            $('#attendBtn').on('click', function() {
                const id = $(this).data('id');
                // Implement your attend functionality here
                console.log('Attend button clicked for event:', id);

                // Example AJAX call (uncomment and modify as needed)
                /*
                $.ajax({
                    url: '/events/' + id + '/attend',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Амжилттай бүртгэгдлээ!');
                    },
                    error: function(error) {
                        alert('Алдаа гарлаа: ' + error.responseJSON.message);
                    }
                });
                */
            });

            // Reminder button handler
            $('#reminderBtn').on('click', function() {
                const id = $(this).data('id');
                $('#reminderEventId').val(id);
                $('#eventModal').modal('hide');
                setTimeout(function() {
                    $('#reminderModal').modal('show');
                }, 500);
            });

            // Share button handler
            $('#shareBtn').on('click', function() {
                const id = $(this).data('id');
                // Set the share link
                const shareUrl = window.location.origin + '/events/' + id;
                $('#shareLink').val(shareUrl);

                // Setup social sharing
                $('#shareFacebook').attr('data-href', shareUrl);
                $('#shareTwitter').attr('data-href', shareUrl);
                $('#shareWhatsapp').attr('data-href', shareUrl);
                $('#shareEmail').attr('href', 'mailto:?subject=Үйл явдалд урьж байна&body=' + encodeURIComponent('Энэ үйл явдлыг үзэх: ' + shareUrl));

                $('#eventModal').modal('hide');
                setTimeout(function() {
                    $('#shareModal').modal('show');
                }, 500);
            });
        });

        // Handle reminder modal
        $('#reminderModal').on('shown.bs.modal', function() {
            // Setup modal close button
            $('.close, button[data-dismiss="modal"]').on('click', function() {
                $('#reminderModal').modal('hide');
            });

            // Save reminder button
            $('#saveReminderBtn').on('click', function() {
                const eventId = $('#reminderEventId').val();
                const reminderType = $('#reminderType').val();
                const reminderTime = $('#reminderTime').val();

                console.log('Reminder saved:', {
                    eventId: eventId,
                    type: reminderType,
                    time: reminderTime
                });

                // Example AJAX call (uncomment and modify as needed)
                /*
                $.ajax({
                    url: '/events/' + eventId + '/reminder',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: reminderType,
                        time: reminderTime
                    },
                    success: function(response) {
                        alert('Сануулга амжилттай тохируулагдлаа!');
                        $('#reminderModal').modal('hide');
                    },
                    error: function(error) {
                        alert('Алдаа гарлаа: ' + error.responseJSON.message);
                    }
                });
                */

                // For demo purposes
                alert('Сануулга амжилттай тохируулагдлаа!');
                $('#reminderModal').modal('hide');
            });
        });

        // Handle share modal
        $('#shareModal').on('shown.bs.modal', function() {
            // Setup modal close button
            $('.close, button[data-dismiss="modal"]').on('click', function() {
                $('#shareModal').modal('hide');
            });

            // Copy link button
            $('#copyLinkBtn').on('click', function() {
                const linkInput = document.getElementById('shareLink');
                linkInput.select();
                document.execCommand('copy');
                alert('Холбоос хуулагдлаа!');
            });

            // Social sharing buttons
            $('#shareFacebook').on('click', function() {
                const url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent($('#shareLink').val());
                window.open(url, 'facebook-share', 'width=580,height=296');
            });

            $('#shareTwitter').on('click', function() {
                const url = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent('Энэ үйл явдлыг үзээрэй!') + '&url=' + encodeURIComponent($('#shareLink').val());
                window.open(url, 'twitter-share', 'width=550,height=235');
            });

            $('#shareWhatsapp').on('click', function() {
                const url = 'https://api.whatsapp.com/send?text=' + encodeURIComponent('Энэ үйл явдлыг үзээрэй: ' + $('#shareLink').val());
                window.open(url, 'whatsapp-share', 'width=580,height=550');
            });

            $('#shareEmail').on('click', function() {
                const subject = 'Үйл явдалд урьж байна';
                const body = 'Энэ үйл явдлыг үзээрэй: ' + $('#shareLink').val();
                window.location.href = 'mailto:?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
            });
        });

        // Populate event data in modal when clicking on event links
        $('.event-link').on('click', function(e) {
            e.preventDefault();
            const eventId = $(this).data('id');

            // Fetch event details and populate the modal
            $.ajax({
                url: '/api/events/' + eventId,
                method: 'GET',
                success: function(event) {
                    // Populate modal fields
                    $('#eventTitle').text(event.title);
                    $('#eventTime').text(moment(event.start_time).format('YYYY-MM-DD HH:mm') + ' - ' + moment(event.end_time).format('YYYY-MM-DD HH:mm'));
                    $('#eventLocation').text(event.location || 'Тодорхойгүй');
                    $('#eventDescription').text(event.description || 'Тайлбар байхгүй');
                    $('#eventCategory').text(event.category || 'Ангилал байхгүй');

                    // Set button data attributes
                    $('#attendBtn').data('id', event.id);
                    $('#reminderBtn').data('id', event.id);
                    $('#shareBtn').data('id', event.id);

                    // Show modal
                    $('#eventModal').modal('show');
                },
                // error: function(error) {
                //     console.error('Error fetching event details:', error);
                //     alert('Үйл явдлын мэдээлэл авахад алдаа гарлаа.');
                // }
            });
        });











    </script>
    @endsection









