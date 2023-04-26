<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
    integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"
    integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
    .tab-container {
        position: relative;
    }

    .tab {
        padding: 8px 16px;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease-in-out;
        font-weight: bold;
    }

    .tab.active {
        border-bottom-color: #374151;
    }

    .tab-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        background-color: #E5E7EB;
        border-radius: 50%;
        border: 2px solid transparent;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .tab-arrow.left {
        left: 0;
    }

    .tab-arrow.right {
        right: 0;
    }

    .tab-arrow:hover {
        background-color: #9CA3AF;
    }

    .tab-arrow.left:hover {
        transform: translate(-3px, -50%);
    }

    .tab-arrow.right:hover {
        transform: translate(3px, -50%);
    }

    @media screen and (min-width: 640px) {
        .tabs {
            overflow-x: hidden;
        }

        .tab {
            display: inline-block;
        }

        .tab-arrow {
            display: block;
        }
    }

</style>
<div class="container mx-auto px-4 py-3" style="overflow: hidden;">
    <div class="tab-container">
        <div class="tabs overflow-x-scroll whitespace-nowrap flex flex-nowrap py-2">
            <a href="#" class="tab active">Tab 1</a>
            <a href="#" class="tab">Tab 2</a>
            <a href="#" class="tab">Tab 3</a>
            <a href="#" class="tab">Tab 4</a>
            <a href="#" class="tab">Tab 5</a>
        </div>
        <div class="tab-arrow left hidden lg:block"></div>
        <div class="tab-arrow right hidden lg:block"></div>
    </div>
    <div class="tab-content py-4">
        <div class="active">
            <p>Tab 1 Content</p>
        </div>
        <div>
            <p>Tab 2 Content</p>
        </div>
        <div>
            <p>Tab 3 Content</p>
        </div>
        <div>
            <p>Tab 4 Content</p>
        </div>
        <div>
            <p>Tab 5 Content</p>
        </div>
    </div>


</div>
<script>
    const tabs = document.querySelector('.tabs');
    const tabContent = document.querySelector('.tab-content');
    const tabTitles = tabs.querySelectorAll('a');
    const tabSections = tabContent.querySelectorAll('div');
    const leftArrow = document.querySelector('.tab-arrow.left');
    const rightArrow = document.querySelector('.tab-arrow.right');

    let activeIndex = 0;

    // Set the active tab
    function setActiveTab(index) {
        // Set the active tab title
        tabTitles.forEach(tabTitle => tabTitle.classList.remove('active'));
        tabTitles[index].classList.add('active');
        // Set the active tab content section
        tabSections.forEach(tabSection => tabSection.classList.remove('active'));
        tabSections[index].classList.add('active');
        activeIndex = index;
    }

    // Handle tab clicks
    tabs.addEventListener('click', event => {
        event.preventDefault();
        const clickedTab = event.target.closest('a');
        if (clickedTab && tabs.contains(clickedTab)) {
            const clickedIndex = Array.from(tabTitles).indexOf(clickedTab);
            setActiveTab(clickedIndex);
        }
    });

    // Make tabs draggable
    let isDragging = false;
    let startPos = 0;
    let currentTranslate = 0;

    tabs.addEventListener('mousedown', event => {
        isDragging = true;
        startPos = event.clientX;
    });

    tabs.addEventListener('mousemove', event => {
        if (isDragging) {
            const distance = event.clientX - startPos;
            currentTranslate += distance;
            tabs.style.transform = `translateX(${currentTranslate}px)`;
            startPos = event.clientX;
        }
    });

    tabs.addEventListener('mouseup', event => {
        isDragging = false;
    });

    tabs.addEventListener('mouseleave', event => {
        isDragging = false;
    });

    // Handle arrow controls
    leftArrow.addEventListener('click', event => {
        const prevIndex = activeIndex - 1 < 0 ? tabTitles.length - 1 : activeIndex - 1;
        setActiveTab(prevIndex);
    });

    rightArrow.addEventListener('click', event => {
        const nextIndex = activeIndex + 1 >= tabTitles.length ? 0 : activeIndex + 1;
        setActiveTab(nextIndex);
    });

</script>
