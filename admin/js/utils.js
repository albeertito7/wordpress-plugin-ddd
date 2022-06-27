const utils_deps = {
    _document: document,
    _jQuery: jQuery.noConflict() || $
}

const utils = (function (_deps) {

    $ = _deps._jQuery;

    // private methods
    function __() {
        return "Silence is golden";
    }

    // public methods
    return {

    }
}(utils_deps));