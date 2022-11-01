import moveableSetup from './events/moveableSetup';

export default {
    install: (app, options) => {
        /* if (typeof window !== 'undefined') {
            //Initialize Data Object
            window.moveableData = {};

            //Create moving class
            window.moveableData.class = {
                moving: 'moveable-moving',
                moveable: 'moveable',
            };

            //Create stylesheet for moveable objets
            const styleElement = document.createElement('style');
            styleElement.innerHTML = `.${window.moveableData.class.moving}::before{content:"";position:absolute;top:0px;left: 0px;width:100%;height:100%;z-index:2;}.${window.moveableData.class.moveable}{cursor: move;}`;
            document.body.appendChild(styleElement);
        } */

        app.directive('moveable', {
            mounted(el, binding) {
                window.moveableData = {};

                //Create moving class
                window.moveableData.class = {
                    moving: 'moveable-moving',
                    moveable: 'moveable',
                };

                //Create stylesheet for moveable objets
                const styleElement = document.createElement('style');
                styleElement.innerHTML = `.${window.moveableData.class.moving}::before{content:"";position:absolute;top:0px;left: 0px;width:100%;height:100%;z-index:2;}.${window.moveableData.class.moveable}{cursor: move;}`;
                document.body.appendChild(styleElement);

                moveableSetup(el, binding);
            },
            updated(el, binding) {
                // Remove events from updated element
                el.onmousedown = null;
                el.ontouchstart = null;

                moveableSetup(el, binding);
            },
        });
    },
};
