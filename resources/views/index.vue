<template xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">

                <div class="col-xs-12">
                    <h1>Manage Prizes</h1>
                </div>

                <div style="margin-bottom: 10px;">
                    <button id='add' class='btn btn-primary btn-md'>
                        <i class='fa fa-plus-circle'></i> ADD NEW PRIZE
                    </button>
                </div>

                <b-card class="col-xs-12">
                    <datatable :headers="['Name', 'Description', 'Quantity', 'Image', 'Actions']"
                               :columns="columns"
                               :url="url"/>
                    <!--:buttons="buttons"-->

                </b-card>
            </div><!--/.col-->
            <!-- Modal Component -->
            <b-modal id="modal1" ref="myModalRef" centered title="Delete Event" @ok="deleteEvent">
                <p class="my-4">Are you sure you want to delete this event?</p>
            </b-modal>
        </div><!--/.row-->
    </div>
</template>

<script>
    export default {
        name: 'Events',
        middleware: 'auth',
        loading: true,
        data () {
            const router = this.$router;
            return {
                columns: [
                    {data: 'name'},
                    {data: 'description'},
                    {data: 'quantity'},
                    {data: 'image'},
                    {data: 'actions', bSortable: false, bSearchable: false}
                ],
                filter: {
                    all: 0,
                    attended: 0,
                    invited: 0,
                    winners: 0,
                    lastClickedId: ''
                },
                url: '',
                idToDelete: '',
                eventId: 0
//                prizeId: 0
            }
        },
        watch: {
            '$route': 'fetchData'
        },
        created () {
            this.fetchData();
            console.log("event_id: " + this.eventId);
        },
        mounted: function () {
            var component = this;

            /**
             * Add button
             */
            $(document).on('click', '#add', {component: this}, function (e) {
                e.data.component.$router.push({path: `form`})
            });

            /**
             * Edit button
             */
            $(document).on('click', '#edit', {component: this}, function (e) {
                var id = $(this).data('id');
                e.data.component.$router.push({path: `form/${id}`})
            });

            /**
             * Delete button
             */
            $(document).on('click', '#delete', function (e) {
                var id = $(this).data('id');
                component.idToDelete = id;
                component.$root.$emit('bv::show::modal', 'modal1');
                console.log(component.idToDelete);
            })
        },
        methods: {
            /**
             * Fetches the data for edit
             */
            fetchData () {
                var component = this;

                this.item.eventId = this.$route.params.event_id;
                if (typeof (this.item.eventId) === 'undefined') return false;
                this.url = this.$apiUrl2 + `organizer-events/${this.item.eventId}/attendees`;

                this.loadFilterCount();

                /**
                 * Filter All button
                 */
                $(document).on('click', '#filter-all', function (e) {
                    this.url = component.$apiUrl2 + `organizer-events/${component.item.eventId}/attendees`;
                    console.log(this.url);
                    component.getLastClickedId('#filter-all');
                    $('table').DataTable().ajax.url(this.url);
                    $('table').DataTable().draw(false);
                });

                /**
                 * Filter Attended button
                 */
                $(document).on('click', '#filter-attended', function (e) {
                    this.url = component.$apiUrl2 + `organizer-events/${component.item.eventId}/attendees/attended`;
                    component.getLastClickedId('#filter-attended');
                    console.log(this.url);
                    $('table').DataTable().ajax.url(this.url);
                    $('table').DataTable().draw(false);
                });

                /**
                 * Filter Invited button
                 */
                $(document).on('click', '#filter-invited', function (e) {
                    this.url = component.$apiUrl2 + `organizer-events/${component.item.eventId}/attendees/invited`;
                    component.getLastClickedId('#filter-invited');
                    $('table').DataTable().ajax.url(this.url);
                    $('table').DataTable().draw(false);
                });

                /**
                 * Filter Pending button
                 */
                $(document).on('click', '#filter-winners', function (e) {
                    this.url = component.$apiUrl2 + `organizer-events/${component.item.eventId}/attendees/winners`;
                    console.log(this.url);
                    component.getLastClickedId('#filter-winners');
                    $('table').DataTable().ajax.url(this.url);
                    $('table').DataTable().draw(false);
                });
            },
            deleteEvent () {
                var component = this
                axios.delete(`organizer-events/${this.eventId}/prizes/${this.idToDelete}`)
                        .then(function (response) {
                            component.$swal.success('Successfully deleted an event')
                            component.$root.$emit('bv::hide::modal', 'modal1')
                            $('table').DataTable().draw(false)
                        }).catch(function (error) {
                    component.$swal.error()
                })
            },
            fetchData () {
                this.eventId = this.$route.params.event_id;
                if (typeof (this.eventId) === 'undefined') return false
                this.url = this.$apiUrl2 + `organizer-events/${this.eventId}/prizes/`
            }
        }
    }
</script>
