import Swal from 'sweetalert2'

const BASE_CLASS = {
    popup: 'text-gray-900 dark:text-white bg-white rounded-lg shadow dark:bg-gray-700',
    actions: 'gap-2',
    cancelButton: 'py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700',
    confirmButton: 'text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:focus:ring-primary-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center',
}

export function swalError(text = 'Uh oh ') {
    Swal.fire({
        showConfirmButton: true,
        icon: 'error',
        customClass: {
            ...BASE_CLASS,
        },
        title: 'Error',
        text: text,
    });
}

export function swalConfirmSubmit(event, formId) {
    event.preventDefault();

    Swal.fire({
        showConfirmButton: true,
        showCancelButton: true,
        icon: 'question',
        customClass: {
            ...BASE_CLASS,
        },
        title: 'Are you sure?',
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
            return true;
        } else {
            return false;
        }
    });
}

export function swalSuccess(text = 'Congrats') {
    Swal.fire({
        showConfirmButton: false,
        icon: 'success',
        timer: 1200,
        timerProgressBar: true,
        customClass: {
            ...BASE_CLASS,
        },
        title: 'Success',
        text: text,
    });
}
