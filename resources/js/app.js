import AppLayout from "@/Layouts/AppLayout";
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetActionSection from '@/Jetstream/ActionSection'
import JetButton from '@/Jetstream/Button'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetCheckbox from '@/Jetstream/Checkbox'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import VCalendar from 'v-calendar';



require('./bootstrap');

// Import modules...
import Vue from 'vue';
import vSelect from 'vue-select'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import 'vue-select/dist/vue-select.css';
import VueTailwind from 'vue-tailwind'
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import VueFormulate from '@braid/vue-formulate'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {
    TInput,
    TTextarea,
    TSelect,
    TRadio,
    TCheckbox,
    TButton,
    TInputGroup,
    TCard,
    TAlert,
    TModal,
    TDropdown,
    TRichSelect,
    TPagination,
    TTag,
    TRadioGroup,
    TCheckboxGroup,
    TTable,
    TDatepicker,
    TToggle,
    TDialog,
} from 'vue-tailwind/dist/components';

locale.use(lang);

const settings = {
    't-input': {
        component: TInput,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
        }
    },
    't-textarea': {
        component: TTextarea,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
        }
    },
    't-rich-select': {
        component: TRichSelect,
        props: {
            fixedClasses: {
                wrapper: 'absolute',
                buttonWrapper: 'inline-block relative w-full',
                selectButton: 'w-48 h-10 flex text-left justify-between items-center px-3 py-2 text-black transition duration-100 ease-in-out border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed',
                selectButtonLabel: 'block truncate',
                selectButtonPlaceholder: 'block truncate',
                selectButtonClearButton: 'rounded flex flex-shrink-0 items-center justify-center absolute right-0 top-0 m-2 h-6 w-6 transition duration-100 ease-in-out',
                selectButtonClearIcon: 'fill-current h-3 w-3',
                dropdown: 'absolute h-52 w-auto z-50 -mt-1 border-b border-l border-r rounded-b shadow-md overflow-y-auto',
                optionsList: 'overflow-auto',
                searchWrapper: 'inline-block w-full',
                searchBox: 'inline-block w-full',
                option: 'cursor-pointer',
                disabledOption: 'opacity-50 cursor-not-allowed',
                highlightedOption: 'cursor-pointer',
                selectedOption: 'cursor-pointer',
                selectedHighlightedOption: 'cursor-pointer',
                optionLabel: 'truncate block',
                selectedIcon: 'fill-current h-4 w-4',
                selectButtonIcon: 'fill-current flex-shrink-0 ml-1 h-4 w-4'
            },
            classes: {
                wrapper: '',
                buttonWrapper: '',
                selectButton: 'bg-white border-gray-300',
                selectButtonLabel: '',
                selectButtonPlaceholder: 'text-gray-400',
                selectButtonIcon: 'text-gray-400',
                selectButtonClearButton: 'hover:bg-blue-100 text-gray-600',
                selectButtonClearIcon: '',
                dropdown: 'absolute bg-white border-gray-300',
                dropdownFeedback: 'pb-2 px-3 text-gray-400 text-sm',
                loadingMoreResults: 'pb-2 px-3 text-gray-400 text-sm',
                optionsList: '',
                searchWrapper: 'p-2 placeholder-gray-400',
                searchBox: 'px-3 py-2 bg-gray-50 text-sm rounded border focus:outline-none focus:shadow-outline border-gray-300',
                optgroup: 'appearance-none border w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md ',
                option: '',
                disabledOption: '',
                highlightedOption: 'bg-blue-500 ',
                selectedOption: 'font-semibold bg-blue-500 font-semibold text-white',
                selectedHighlightedOption: 'font-semibold bg-gray-100 bg-blue-600 font-semibold text-white',
                optionContent: 'flex justify-between items-center px-3 py-2',
                optionLabel: '',
                selectedIcon: '',
                enterClass: '',
                enterActiveClass: 'opacity-0 transition ease-out duration-100',
                enterToClass: 'opacity-100',
                leaveClass: 'transition ease-in opacity-100',
                leaveActiveClass: '',
                leaveToClass: 'opacity-0 duration-75'
            },
            variants: {}
        }
    },
    't-select': {
        component: TSelect,
        props: {
            wrapped: true,
            fixedClasses: {
                wrapper: 'relative',
                arrowWrapper: 'pointer-events-none absolute inset-y-0 right-0 flex items-center px-2'
            },
            classes: {
                wrapper: 'relative',
                input: 'appearance-none border w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md',
                arrowWrapper: 'text-gray-700',
                arrow: ''
            },
            variants: {}
        }
    }
}

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(VueFormulate);
Vue.use(VCalendar, {
    componentPrefix: 'vc',
});
Vue.use(ElementUI);
Vue.component('v-select', vSelect)
Vue.use(VueTailwind, settings)
Vue.component('app-layout', AppLayout);
Vue.component('jet-secondary-button', JetSecondaryButton);
Vue.component('jet-section-border', JetSectionBorder);
Vue.component('jet-label', JetLabel);
Vue.component('jet-input-error', JetInputError);
Vue.component('jet-check-box', JetCheckbox);
Vue.component('jet-input', JetInput);
Vue.component('jet-form-section', JetFormSection);
Vue.component('jet-dialog-modal', JetDialogModal);
Vue.component('jet-confirmation-modal', JetConfirmationModal);
Vue.component('jet-button', JetButton);
Vue.component('jet-action-section', JetActionSection);
Vue.component('jet-action-message', JetActionMessage);
Vue.component('jet-danger-button', JetDangerButton);




const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
