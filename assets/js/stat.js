let duration_bars = document.querySelectorAll('.wrap-duration-item');

duration_bars.forEach(function(duration) {
    let after = duration.querySelector('.duration-after');
    let percentage = duration.querySelector('.duration-percentage').innerHTML;
    after.style.width = 'calc(' + percentage + ' - 10px)';
});