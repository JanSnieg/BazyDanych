dZad 1
SELECT dayname( date_add( @data, interval year (curdate()) - year(@data) year ));

Zad 2
select date_sub(@return_date, interval if(dayofweek(@return_date)=1,2, if(dayofweek(@return_date)=7,1,0)) day);

Zad 3
set @dateofbirth =  '2000-11-11'
różnica lat, sprawdzmy czy curdate jest większe lub równe od daty urodzin, jeśli nie to minus 1

Zad 4
select concat(@firstname, ' ', @lastname);
select concat(@firstname, '_', @lastname);

Zad 5
set @first = left (@firstname,2 ); 
set @second = left (@lastname,2 ); 
select concat( if (@first = 'Ch', @first, left(@first,1)) , '.', if (@second = 'Ch', @second, left(@second,1)), '.') as Inicjały;

Zad 6
select left(right(format(PI(),11),2),1);

Zad 7
set @faces=6;
select round((rand()*(@faces-1))+1) as “Rzut kostką”;

Zad 8
set @spacja = length(@name)-length(replace(@name,' ',''));
set @firstname = substring_index(@name, ' ', @spacja);
set @lastname = substring_index(@name, ' ', -1);
select json_object("firstname", @firstname, "lastname", @lastname) as JSon;
