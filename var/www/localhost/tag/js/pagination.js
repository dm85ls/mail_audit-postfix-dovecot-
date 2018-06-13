$.fn.pageMe = function(opts){ //Функция пагинации
    var $this = this,
        defaults = { //стандартные настройки
            activeColor: 'blue',
            perPage: 10,
            showPrevNext: false,
            nextText: '',
            prevText: '',
            hidePageNumbers: false
        },
    settings = $.extend(defaults, opts);

  var listElement = $this.find("tbody");
  var perPage = settings.perPage;
  var children = listElement.children();
  var pager = $('.pager');

  if (typeof settings.childSelector != "undefined") {
    children = listElement.find(settings.childSelector);
  }

  if (typeof settings.pagerSelector != "undefined") {
    pager = $(settings.pagerSelector);
  }

  var numItems = children.size(); //Получаем общее кол-во результатов
  var numPages = Math.ceil(numItems / perPage); //Получаем кол-во страниц

  pager.data("curr", 0);

  if (settings.showPrevNext) { //Если showPrevNext=true, то добавляем линк для первой страницы
	$('<li><a href="#" class="start_link">1</a></li>').appendTo(pager); 
  }
  
  if (settings.showPrevNext) { //Если showPrevNext=true, то добавляем линк для предыдущей страницы
    $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
  }

  var curr = 0; //Создаем переменную для страниц

  while (numPages > curr && (settings.hidePageNumbers == false)) { //Присваиваем страницам номера
    $('<li id="pg' + (curr + 1) + '" class="pg"><a href="#" class="page_link">' + (curr + 1) + '</a></li>').appendTo(pager);
    curr++;
  }


  if (settings.showPrevNext) { //Если showPrevNext=true, то добавляем линк для следующей страницы
    $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
  }
  if (settings.showPrevNext) { //Если showPrevNext=true, то добавляем линк для последней страницы
    $('<li><a href="#" class="last_link">' + (numPages) + '</a></li>').appendTo(pager);
  }

  pager.find('.page_link:first').addClass('active'); //Начало с первой страницы
  pager.find('.prev_link').hide(); //Скрываем ссылку на предыдущую страницу
  pager.find('.start_link').hide(); //Скрываем ссылку на первую страницу
  if (numPages <= 1) { //Если число страниц меньше 1
    pager.find('.next_link').hide(); //Скрываем ссылку на следующую страницу
	pager.find('.last_link').hide(); //Скрываем ссылку на последную страницу
  }
  pager.children().eq(1).addClass("active");

  children.hide();
  children.slice(0, perPage).show();
  if (numPages > 5) { //Если число страниц больше 5
    $('.pg').hide();
    $('#pg1,#pg2,#pg3,#pg4,#pg5').show(); //Показываем ссылку на первую пять страниц
    $("#pg5").after($("<li class='ell'>").html("<span>...</span>")); //После 5 страницы отображаем "..."
  }

  pager.find('li .page_link').click(function() { //Активация функции перехода по страницам
    var clickedPage = $(this).html().valueOf() - 1;
    goTo(clickedPage, perPage);
    return false;
  });
  pager.find('li .start_link').click(function() { //Активация функции для перехода на первую старницу
    firstpage();
    return false;
  });
  pager.find('li .prev_link').click(function() { //Активация функции для перехода на предыдущую старницу
    previous();
    return false;
  });
  pager.find('li .next_link').click(function() { //Активация функции для перехода на следующую старницу
    next();
    return false;
  });
  pager.find('li .last_link').click(function() { //Активация функции для перехода на последную старницу
    lastpage();
    return false;
  });

  function firstpage() { 
    var goToPage = 0; //Переход на первую страницу
    goTo(goToPage);
  }
  
  function previous() {
    var goToPage = parseInt(pager.data("curr")) - 1; //Переход на предыдущую страницу
    goTo(goToPage);
  }

  function next() {
    goToPage = parseInt(pager.data("curr")) + 1; //Переход на слудующую страницу
    goTo(goToPage);
  }
  
  function lastpage() {
    goToPage = numPages - 1; //Переход на последную страницу
    goTo(goToPage);
  }


  function goTo(page) { //переход по страницам
    var startAt = page * perPage,
      endOn = startAt + perPage;


    $('.pg').hide();
    $(".ell").remove();
	//Кнопки для отображения на страницы
	var ppprevpg = $("#pg" + (page - 2)).show();
	var pprevpg = $("#pg" + (page - 1)).show();
    var prevpg = $("#pg" + page).show();
    var currpg = $("#pg" + (page + 1)).show();
    var nextpg = $("#pg" + (page + 2)).show();
	var nnextpg = $("#pg" + (page + 3)).show();
	var nnnextpg = $("#pg" + (page + 4)).show();
    if (prevpg.length == 0) nextpg = $("#pg" + (page + 4)).show();
    if (prevpg.length == 1 && nextpg.length == 0) {
      prevpg = $("#pg" + (page - 1)).show();
    }
    if (curr > 5) {
      if (page > 3) prevpg.before($("<li class='ell'>").html()) && pprevpg.before($("<li class='ell'>").html()) && ppprevpg.before($("<li class='ell'>").html("<span>...</span>"));
      if (page < curr - 4) nextpg.after($("<li class='ell'>").html()) && nnextpg.after($("<li class='ell'>").html()) && nnnextpg.after($("<li class='ell'>").html("<span>...</span>"));
    }
    currpg.addClass("active").siblings().removeClass("active");
    // Added few lines till here end


    children.css('display', 'none').slice(startAt, endOn).show();

    if (page >= 1) { //Отображение/показ кнопки "предыдущая страница"
      pager.find('.prev_link').show();
    } else {
      pager.find('.prev_link').hide();
    }
	
	if (page >= 4) { //Отображение/показ кнопки "первая страница"
	  pager.find('.start_link').show();
    } else {
	  pager.find('.start_link').hide();
    }

    if (page < (numPages - 1)) { //Отображение/показ кнопки "следующая страница"
      pager.find('.next_link').show();
    } else {
      pager.find('.next_link').hide();
    }
	
	if (page < (numPages - 4)) { //Отображение/показ кнопки "последняя страница"
      pager.find('.last_link').show();
    } else {
      pager.find('.last_link').hide();
    }

    pager.data("curr", page);
    /*pager.children().removeClass("active");
    pager.children().eq(page + 1).addClass("active");*/

  }
};
