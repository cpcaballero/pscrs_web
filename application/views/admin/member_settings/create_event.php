
<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12">
                    <h4><strong>Create Event</strong></h4>
                </div>

                <div class="col s12">

                    <div class="row col s6">
                        <h5>Event Title:</h5>
                        <input placeholder="Placeholder" id="title" name="title" type="text" class="validate">
                        <h5>Date:</h5>
                        <input type="date" id="datetime" name="datetime" class="">
                        <h5>Description:</h5>
                        <textarea id="event" name="description"></textarea>

                        <div class="input-field col s12 right-align">
                            <button id="create_event_submit" type="button" class="btn light-blue darken-2 create">Create</button>
                            <a href="<?= base_url('Admin_FE/member_settings') ?>" class="btn teal darken-2">Cancel</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>
