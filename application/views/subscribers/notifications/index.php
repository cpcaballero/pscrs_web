<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <h4><strong>Notifications</strong></h4>
                    <br>
                    <?php if ($notifs) : ?>
                        <?php foreach ($notifs as $notif) : ?>
                            <?php if (($notif->recipient == 0 || $notif->recipient == $_SESSION['account']['details']['id']) && $notif->status == 1) : ?>
                                <h6><strong><?= $notif->title ?></strong></h6>
                                <p><?= $notif->description ?></p>
                                <hr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <h4>You have 0 notifications yet.</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>