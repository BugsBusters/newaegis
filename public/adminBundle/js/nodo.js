function setPosition(element, x, y, map) {
    console.log(map.offset());
    element.offset({
        left: map.offset().left + (x * map.width()),
        top:  map.offset().top + (y * map.height())
    })

}

