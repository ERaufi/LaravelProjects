$(function () {
    let jquerySPA = {
        'sidebar': '#layout-menu', //Add your main sidebar div id or className
        'navbar': '#layout-navbar', //Add your main navbar div id or className
        'content': '.content-wrapper', //Add your main content section div id or className
        'links': ".menu-link", //add your links id or className
    }

    //keeping track of the url changes
    let browserHistory = ['/'];


    //Prevent the default functionality of the items
    $(document).on('click', jquerySPA['links'], function (event) {
        event.preventDefault();
        let link = $(this);
        changePage(link.attr('href'), link);

    });


    // handling the browser back and forward button
    $(window).on('popstate', function (event) {
        console.log("User pressed back or forward button!");
    });


    function changePage(url, item = null) {
        $.ajax({
            type: 'get',
            url: url,
            success: function (data) {

                //empty the content of the content section so we can start from clean div
                $(jquerySPA['content']).empty();

                //adding the new page to the content section to display
                $(jquerySPA['content']).append(data);

                if (item != null) {
                    //Removing the active class from the sidebar item
                    $(jquerySPA['sidebar']).find('.active').removeClass("active");

                    //adding the active class to the selected link in the sidebar
                    item.parent().addClass('active');
                }


                //pushing the new link to the history of the browser so the
                // user can go back by pressing the browser back button
                history.pushState(null, '', url);
                browserHistory.push(url);
            }
        });
    }
});