import './backend/metabox';
import './backend/modal';
import './backend/poll-builder';
import './backend/settings';
import './backend/report';
import './utilities/collapse';

/**
 * Remove annoying notices from WP Dashboard
 *
 * Place this script on which you don't want
 * to show notices.
 */
document.addEventListener('DOMContentLoaded', function() {
    const isAdmin = () => {
    return document.body.classList.contains('wp-admin');
    }
    if ( isAdmin() ) {
        document.querySelectorAll('.notice')
        .forEach( notice => notice.remove() );
    }
});
