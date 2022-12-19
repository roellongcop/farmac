
const pollNotification = (totalUnread) => {
    $.ajax({
        url: app.baseUrl + 'notification/poll',
        data:{totalUnread},
        method: 'post',
        dataType: 'json',
        success: function(s) {
            if(s.status == 'success') {
                if (parseInt(s.totalUnread) > 0) {
                    $('.notification-badge').replaceWith('<label class="badge badge-danger badge-pill notification-badge">'+s.totalUnread+'</label>')
                    pollNotification(s.totalUnread);
                }
                else {
                    $('.notification-badge').replaceWith('<label class="notification-badge"></label>')
                    pollNotification(0);
                }

            }
            else {
                pollNotification(totalUnread);
            }
        },
        error: function(e) {
            console.log(e)
        }
    })
}

$('.notification .topbar-item').on('click', function(e) {
	e.preventDefault();

	KTApp.block('.notification-content');

	$.ajax({
		url: app.baseUrl + 'notification/load',
		dataType: 'json',
		success: (s) => {
			if (s.status == 'success') {
				if (s.notifications) {
					$('.notification-content').html(s.notifications);
				}
				else {
					$('.notification-content').html('No New Notifications');
				}
			}
			else {
				Swal.fire('Error', s.errorSummary, 'error');
			}
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
		}
	})
})