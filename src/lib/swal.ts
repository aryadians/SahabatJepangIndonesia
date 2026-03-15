import Swal from 'sweetalert2';

export const showSuccess = (title: string, text: string) => {
  return Swal.fire({
    title,
    text,
    icon: 'success',
    confirmButtonColor: '#0047AB', // Corporate Blue
  });
};

export const showError = (title: string, text: string) => {
  return Swal.fire({
    title,
    text,
    icon: 'error',
    confirmButtonColor: '#E03E3E', // Corporate Red
  });
};

export const showConfirm = (title: string, text: string) => {
  return Swal.fire({
    title,
    text,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#0047AB',
    cancelButtonColor: '#E03E3E',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  });
};
