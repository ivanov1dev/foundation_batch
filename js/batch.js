(function ($) {

    var batch = {
        id: null,
        base: null,
        process_url: null,
        complete_url: null,

        wrapper: null,
        wrapper_message: null,
        wrapper_current: null,
        wrapper_total: null,
        wrapper_progress: null,

        init: function(base, id, wrapper) {
            this.id = id;

            this.base = base;
            this.process_url = this.base + "batch_job/" + this.id + "/process";
            this.complete_url = this.base + "batch_job/" + this.id + "/complete";

            this.wrapper = $(wrapper);
            this.wrapper_message = this.wrapper.find(".message");
            this.wrapper_current = this.wrapper.find(".current");
            this.wrapper_total = this.wrapper.find(".total");
            this.wrapper_progress = this.wrapper.find(".progress .progress-bar");

            return this;
        },

        process: function() {
            $.ajax({
                url: this.process_url,
                dataType: "json",
                success: function (response) {
                    batch.wrapper_message.text(response.message);
                    batch.wrapper_current.text(response.current);
                    batch.wrapper_total.text(response.total);

                    batch.wrapper_progress.text(response.percent + "%");
                    batch.wrapper_progress.attr("aria-valuenow", response.percent);
                    batch.wrapper_progress.css({"width": response.percent + "%"});

                    if (response.status == 'complete') {
                        setTimeout(function () {
                            window.location.href = window.location.origin + batch.complete_url;
                        }, 500);
                    }
                    else {
                        setTimeout(function () { batch.process(); }, 200);
                    }
                },
                error: function (xhr) {
                    batch.wrapper_message.text("Ошибка. " + xhr.status + " " + xhr.responseText);
                }
            });
        }
    };

    Drupal.behaviors.batchJobInit = {
        attach: function(context, settings) {
            $(".batch-job-wrapper").once(function() {
                batch.init(settings.basePath, settings.batch.id, this).process();
            });
        }
    };

}(jQuery));
