
<div class="batch-job-wrapper">
  <p><?php print $job->description(); ?></p>
  <div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="<?php print $job->percent(); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php print $job->percent(); ?>%;">
      <?php print $job->percent(); ?>%
    </div>
  </div>
  <p>
    <span class="current"><?php print $job->current(); ?></span> из <span class="total"><?php print $job->total(); ?></span>
  </p>
  <p class="message"><?php print $job->message(); ?></p>
</div>
