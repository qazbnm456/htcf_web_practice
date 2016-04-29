(function() {
    'use strict';
    var palette_elem = document.getElementById('ps-palette');
    var palette_canvas = palette_elem ? palette_elem.getContext('2d') : null;

    var pixels_elem = document.getElementById('ps-pixels');
    var pixels_canvas = pixels_elem ? pixels_elem.getContext('2d') : null;

    var colorpicker = document.getElementById('ps-palette-picker');

    var save_form_data = document.getElementById('ps-savedata');
    var save_form = document.getElementById('ps-saveform');

    var state = {};

    function init_palette(palette) {
        state.pal = palette;
        state.pal_w = 16;
        state.pal_h = 16;
        state.pal_sel = -1;
        draw_palette();
        draw_colorpicker();
    }

    function init_pixels(w, h, px) {
        state.im_w = w;
        state.im_h = h;
        state.im = px;
        draw_pixels();
    }

    function draw_palette() {
        if(!palette_elem)
            return;

        var scale = Math.floor(Math.min(palette_elem.width / state.pal_w, palette_elem.height / state.pal_h));
        for(var i=0; i<state.pal.length; i++) {
            var x = i % state.pal_w;
            var y = Math.floor(i / state.pal_w);
            palette_canvas.beginPath();
            palette_canvas.fillStyle = state.pal[i];
            palette_canvas.fillRect(x * scale, y * scale, scale, scale);
            palette_canvas.strokeStyle = (i == state.pal_sel) ? "#f70" : "#333";
            palette_canvas.strokeRect(x * scale, y * scale, scale, scale);
        }

        /* draw plus sign to add a new color */
        if(state.pal.length < 255) {
            var i = state.pal.length;
            var x = i % state.pal_w;
            var y = Math.floor(i / state.pal_w);
            palette_canvas.fillStyle = '#000';
            palette_canvas.fillRect((x + 0.5) * scale - 1, (y + 0.25) * scale, 2, scale * 0.5);
            palette_canvas.fillRect((x + 0.25) * scale, (y + 0.5) * scale - 1, scale * 0.5, 2);
        }
    }

    function draw_colorpicker() {
        if(!colorpicker)
            return;

        if(state.pal_sel >= 0) {
            colorpicker.style.visibility = 'visible';
            colorpicker.value = state.pal[state.pal_sel];
        } else {
            colorpicker.style.visibility = 'hidden';
            colorpicker.value = '#000000';
        }
    }

    function draw_pixels() {
        if(!pixels_elem)
            return;

        var scale = Math.floor(Math.min(pixels_elem.width / state.im_w, pixels_elem.height / state.im_h));
        for(var i=0; i<state.im.length; i++) {
            var x = i % state.im_w;
            var y = Math.floor(i / state.im_w);
            pixels_canvas.beginPath();
            pixels_canvas.rect(x * scale, y * scale, scale, scale);
            pixels_canvas.fillStyle = state.pal[state.im[i]];
            pixels_canvas.fill();
        }
    }

    function onmousemove_palette(ev) {
        ev = ev || event;
        console.log(ev.buttons);
        if(ev.buttons != 1)
            return;

        var scale = Math.floor(Math.min(palette_elem.width / state.pal_w, palette_elem.height / state.pal_h));

        var rect = this.getBoundingClientRect();
        var x = Math.floor((ev.clientX - rect.left) / scale);
        var y = Math.floor((ev.clientY - rect.top) / scale);

        var ind = y * state.pal_w + x;
        if(ind >= 0 && ind < state.pal.length) {
            state.pal_sel = ind;
        } else if(ind == state.pal.length) {
            state.pal_sel = ind;
            state.pal.push('#ffffff');
        } else {
            state.pal_sel = -1;
        }
        draw_palette();
        draw_colorpicker();
    }

    function onmousemove_pixels(ev) {
        ev = ev || event;
        console.log(ev);
        if(ev.buttons != 1)
            return;

        var scale = Math.floor(Math.min(pixels_elem.width / state.im_w, pixels_elem.height / state.im_h));

        var rect = this.getBoundingClientRect();
        var x = Math.floor((ev.clientX - rect.left) / scale);
        var y = Math.floor((ev.clientY - rect.top) / scale);

        var ind = y * state.im_w + x;
        if(state.pal_sel >= 0 && ind >= 0 && ind < state.im.length) {
            state.im[ind] = state.pal_sel;
            draw_pixels();
        }
    }

    function onpalettechange() {
        if(state.pal_sel >= 0) {
            state.pal[state.pal_sel] = this.value;
            draw_palette();
            draw_pixels();
        }
    }

    function onsave(ev) {
        save_form_data.value = JSON.stringify(state);
    }

    if(palette_elem) {
        palette_elem.addEventListener('mousedown', onmousemove_palette);
        palette_elem.addEventListener('mousemove', onmousemove_palette);
    }

    if(pixels_elem) {
        pixels_elem.addEventListener('mousedown', onmousemove_pixels);
        pixels_elem.addEventListener('mousemove', onmousemove_pixels);
    }

    if(colorpicker) {
        colorpicker.addEventListener('change', onpalettechange);
        colorpicker.addEventListener('input', onpalettechange);
    }

    if(save_form) {
        save_form.addEventListener('submit', onsave);
    }

    var PixelShop = {
        init_palette: init_palette,
        init_pixels: init_pixels,
    };

    window.PixelShop = PixelShop;  
})();
