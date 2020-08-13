import { extend } from 'vee-validate';

import { 
    email, 
    required, 
} from 'vee-validate/dist/rules';

import date_compare from './rules/date_compare';

extend('email', {
    ...email,
    message: 'You should add a valid email address'
});


extend('required', {
    ...required,
    message: 'The {_field_} is required.'
});

extend('is_earlier', {
    validate: (value, { compare }) => {
        return date_compare({value, compare, validationType: 'earlier'});
    },
    params: ['compare', 'dateType'],
    message: 'The selected date must not be earlier than {dateType}'
});

extend('is_beyond', {
    validate: (value, { compare }) => {
        return date_compare({value, compare, validationType: 'beyond'});
    },
    params: ['compare', 'dateType'],
    message: 'The selected date must not be older than {dateType}'
});