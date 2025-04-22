let lastScrollTop = 0;
let mobilePhone = document.querySelector('.mobile-phone');
if (mobilePhone) {
    function adjustElementPosition(clear = null) {

        // Calculate the top position for the fixed state
        let topPosition = (window.innerHeight - mobilePhone.clientHeight) / 2;

        // Transition the top property smoothly
        if (window.scrollY > topPosition) {
            mobilePhone.style.top = `${topPosition}px`;
        } else {
             mobilePhone.style.top = '-50%';
        }
        if (clear) {
        }
    }
    function adjustElementPositionBottom(clear = null) {

        // Calculate the top position for the fixed state
        let topPosition = (window.innerHeight - mobilePhone.clientHeight) / 8;

        // Transition the top property smoothly
        if (window.scrollY > topPosition) {
            mobilePhone.style.top = `${topPosition}px`;
        } else {
             mobilePhone.style.top = '-50%';
        }
        if (clear) {
        }
    }

    const originalTop = // Get the original top value of your fixed element here

    function moveFixedElement() {
        const st = window.pageYOffset || document.documentElement.scrollTop;
        if (st > lastScrollTop) {
            // Scrolling down
            mobilePhone.style.top = `-${mobilePhone.clientHeight}px`;
        } else {
            // Scrolling up
            mobilePhone.style.top = `${originalTop}px`;
        }
        lastScrollTop = st <= 0 ? 0 : st;
    }
    function observeBodyClass(className, callback) {
        var body = document.querySelector('body');

        var observer = new MutationObserver(function (mutationsList) {
            for (var mutation of mutationsList) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    var classList = body.classList;
                    if (classList.contains(className)) {
                        callback(true);
                    } else {
                        callback(false);
                    }
                }
            }
        });

        observer.observe(body, { attributes: true });
    }

    // Example usage
    observeBodyClass('about-me-inView', function (isInView) {
        if (isInView) {
            window.addEventListener('scroll', adjustElementPosition);
        } else {
            window.removeEventListener('scroll', adjustElementPosition);
        }
    });
    observeBodyClass('the-details-inView', function (isInView) {
        if (isInView) {
            window.removeEventListener('scroll', adjustElementPosition);
            mobilePhone.style.top = '-50%';
        } else {
        }
    });

    
    observeBodyClass('last-big-item-inView', function (isInView) {
        if (isInView) {
            window.removeEventListener('scroll', adjustElementPosition);
            window.addEventListener('scroll', moveFixedElement);
            console.log('biglist')
        } else {
        }
    });
    observeBodyClass('featured-work-inView', function (isInView) {
        if (isInView) {
      //      window.removeEventListener('scroll', moveFixedElement);
        } else {
        }
    });

}