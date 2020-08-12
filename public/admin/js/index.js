var editor;
$(document).ready(

    // Sidebar function for display or hidding sublist
    $('.multi-list a:first').click(() => {
        event.preventDefault()
        if ($('.multi-list ul').hasClass('active')) {
            $('.multi-list ul').removeClass('active')
            $('.multi-list ul').css('display', 'none')
        } else {
            event.stopPropagation()
            $('.multi-list ul').addClass('active')
            $('.multi-list ul').css('display', 'block')
        }
    }),

    //Give a random color for statistic block
    $(".procents-block").each((index, item) => {
        item.style.backgroundColor = "rgb(" + Math.floor(Math.random() * Math.floor(255)) + "," + Math.floor(Math.random() * Math.floor(255)) + "," + Math.floor(Math.random() * Math.floor(255)) + ")";

    }),

    //Procents width
    $(".procents-block").each((index, item) => {
        item.style.width = item.innerHTML

    }),

    //Medium Editor

    editor = new MediumEditor('.content-edit'),
    // $('.data-area-hidden').html(editor.getContent())
    $(".content-edit").on('focusout', () => {
        $('.data-area-hidden').html(editor.getContent())
    })

)


//Quick Sort
// let arr = [12, 3, 5, 2, 200, 150, 300, 100, 99, 55]

// function qsort(arr) {
//     if (arr.length < 2) {
//         return arr
//     } else {
//         let pivot = arr[Math.floor(Math.random() * arr.length)]
//         let less = arr.filter(elem => elem < pivot)
//         let more = arr.filter(elem => elem > pivot)
//         return [...qsort(less), pivot, ...qsort(more)]
//     }

// }

// console.log('qsort :>> ', qsort(arr));