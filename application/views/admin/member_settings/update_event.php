<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12">
                    <h4><strong>Update Event</strong></h4>
                </div>

                <div class="col s12">

                    <div class="row col s6">
                        <h5>Event Title:</h5>
                        <input placeholder="Placeholder" id="title" name="title" type="text" class="validate" value="<?= $event->event_title ?>">
                        <h5>Date:</h5>
                        <input type="date" id="datetime" name="datetime" value="<?= date('Y-m-d', strtotime($event->event_date)) ?>">
                        <h5>Description:</h5>
                        <textarea id="event" name="description"><?= $event->event_desc ?></textarea>
                        <input type="hidden" name="id" id="id" value="<?= $event->id ?>">

                        <div class="input-field col s12 right-align">
                            <button id="update_event_submit" type="button" class="btn light-blue darken-2 create">Update</button>
                            <a href="<?= base_url('Admin_FE/member_settings') ?>" class="btn teal darken-2">Cancel</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>