/**
 * Source code adapted from:    https://stackoverflow.com/questions/57652673/javascript-html-datepicker
 * Added more features, like available and unavailable days, etc..
 */

let currentDate = new Date();
let yesterday = new Date();  yesterday.setDate(yesterday.getDate()-1);

let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

let months = ["January", "February", "March", "April", "May", "June", "July","August", "September", "October","November", "December"];
let daysOfTheMonth = ["S","M","T","W","T","F","S"];

var calendarioRef = null;

class Calendar {
    constructor(id,year, month, allowOverlaps, blockedDates, availableDates,allowPast) {
        this.id = id,
        this.year = year,
        this.month = month,
        this.header = months[this.month] + " " + this.year;

        if(allowOverlaps == null || allowOverlaps == "" || allowOverlaps == "false" || allowOverlaps == "0" || allowOverlaps == "-1")
            this.allowOverlaps = false;
        else this.allowOverlaps = true;

        if(allowPast == null || allowPast == "" || allowPast == "false" || allowPast == "0" || allowPast == "-1")
            this.allowPast = false;
        else this.allowPast = true;

        if(blockedDates == undefined || blockedDates == null)
            this.blockedDates = null;
        else this.blockedDates = blockedDates;

        if(availableDates == undefined || availableDates == null)
            this.availableDates = null;
        else this.availableDates = availableDates;

        this.startDate = null;
        this.endDate = null;
        this.calendarBody=null;
        this.calendarHeader=null;
        this.mainHeader=null;
    }
    //Go to previous month    
    previous(calendarBody,calendarHeader,mainHeader){
        this.year = (this.month === 0) ? this.year - 1 : this.year;
        this.month = (this.month === 0) ? 11 : this.month - 1;
        this.update(calendarBody,calendarHeader,mainHeader)
    }
    //Go to next month
    next(calendarBody,calendarHeader,mainHeader) {
        this.year = (this.month === 11) ? this.year + 1 : this.year;
        this.month = (this.month + 1) % 12;
        this.update(calendarBody,calendarHeader,mainHeader)
    }
    current(calendarBody,calendarHeader,mainHeader){
        this.update(calendarBody,calendarHeader,mainHeader);
    }
    
    selectDate(date){

        let year = this.year;
        let month = this.month;
        let newDate =  new Date(year, month, date)
        const newMonth = newDate.toLocaleString('default', { month: 'short' });
        var dayName = newDate.toString().split(' ')[0];
        document.getElementById("topHeader_"+ this.id).innerHTML = dayName+", "+ newMonth + " "+ date;


        if(this.startDate == null){
            this.startDate = newDate;
            document.getElementById("input_"+ this.id+"_start").value = formatDate(newDate);
        }else if(newDate > this.startDate){
            if(this.overlaps(this.startDate,newDate) || !this.allAvailable(this.startDate,newDate)){ // se der overlap reiniciar data inicial
                this.startDate = newDate;
                this.endDate = null;
                document.getElementById("input_"+ this.id+"_start").value = formatDate(newDate);
                document.getElementById("input_"+ this.id+"_end").value = null;
            }else{ //se estiver tudo bem
                this.endDate = newDate;
                document.getElementById("input_"+ this.id+"_end").value = formatDate(newDate);
            }
        }else if(newDate < this.startDate){
            this.startDate = newDate;
            this.endDate = null;
            document.getElementById("input_"+ this.id+"_start").value = formatDate(newDate);
            document.getElementById("input_"+ this.id+"_end").value = null;
        }

    }
    update(calendarBody,calendarHeader,mainHeader){
        let month = currentDate.toLocaleString('default', { month: 'short' });
        let dayName = currentDate.toString().split(' ')[0];
        mainHeader.innerHTML = dayName+", "+ month + " " + currentDate.getDate();

        calendarHeader.innerHTML = months[this.month] + " " + this.year;
        calendarBody.innerHTML = "";
        let firstDay = (new Date(this.year, this.month)).getDay();
        let daysInMonth = 32 - new Date(this.year, this.month, 32).getDate();
        let date = 1;
        for (let i = 0; i < 6; i++) {
            let row = document.createElement("tr");
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    let cell = document.createElement("td");
                    cell.innerHTML = ""
                    row.appendChild(cell);
                }
                else if (date > daysInMonth) {
                    break;
                }
                else {


                    let cell = document.createElement("td");
                    let currentDay = new Date(this.year,this.month,date);
                    let vm = this;
                    if(this.available( currentDay.getTime() )){ // se a data se encontrar disponivel
                    
                            
                            if((this.startDate != null && this.overlapsDates(currentDay,currentDay,this.startDate,this.startDate)) || 
                                (this.endDate != null && this.overlapsDates(currentDay,currentDay,this.startDate,this.endDate))){ //se a data se encontra selecionada
                                    cell.setAttribute('id' , 'selected');
                            }else{ //se a data esta disponivel
                                var which = this.whichDateBoundAvailable(currentDay);
                                //console.log(date,which,this.dateBoundAvailable(currentDay));
                                if(this.dateBoundAvailable(currentDay) == 1){
                                    if(which == 0){
                                        cell.setAttribute('id' , 'right_half');
                                    }else if(which == 1){
                                        cell.setAttribute('id' , 'left_half');
                                    }
                                }
                                else cell.setAttribute('id' , 'available'); 
                            }


                            let button = document.createElement("button");
                            button.innerHTML = date;
                            cell.appendChild(button);
                            button.addEventListener('click',function(e){

                                vm.selectDate(e.target.innerHTML);
                                vm.current(calendarBody,calendarHeader,mainHeader)
                            
                            });
                    
                    }else{ //se a data não encontra disponivel
                        
                        let button = document.createElement("button");
                        button.innerHTML = date;
                        cell.appendChild(button);
                        if(this.allowOverlaps == true && this.dateBoundBlocked(currentDay) == 1 && this.dateBoundAvailable(currentDay) == 0){ //se permitir overlaps e data só é abrangida por uma data limite

                            if((this.startDate != null && this.overlapsDates(currentDay,currentDay,this.startDate,this.startDate)) || 
                                (this.endDate != null && this.overlapsDates(currentDay,currentDay,this.startDate,this.endDate))){
                                    cell.setAttribute('id' , 'selected');
                                    button.addEventListener('click',function(e){

                                        vm.selectDate(e.target.innerHTML);
                                        vm.current(calendarBody,calendarHeader,mainHeader)
                                    
                                    });
                            }else{
                                if(this.inAvailables(currentDay,currentDay)){
                                    var which = this.whichDateBoundBlocked(currentDay);
                                    if(which == 0){
                                        cell.setAttribute('id' , 'left_half');
                                    }else if(which == 1){
                                        cell.setAttribute('id' , 'right_half');
                                    }
                                    else cell.setAttribute('id' , 'half');
                                    button.addEventListener('click',function(e){

                                        vm.selectDate(e.target.innerHTML);
                                        vm.current(calendarBody,calendarHeader,mainHeader)
                                    
                                    });
                                }else{
                                    cell.setAttribute('id' , 'unavailable');
                                    button.addEventListener('click',function(e){
                                        e.preventDefault();                                
                                    });
                                }
                            } 
                        }else{
                            cell.setAttribute('id' , 'unavailable');
                            button.addEventListener('click',function(e){
                                e.preventDefault();                                
                            });
                        }
                    }

                    if (date === currentDate.getDate() && this.year === currentDate.getFullYear() && this.month === currentDate.getMonth()) {
                        cell.classList.add("today");
                    }

                    row.appendChild(cell);
                    date++;

                }
            }
            calendarBody.appendChild(row);
        }
    }
    createPicker(datePicker){
        let vm = this;
        let mainHeader = document.createElement("div");
            mainHeader.setAttribute("id", "topHeader_"+ vm.id)
            mainHeader.classList.add("topHeader");
            mainHeader.innerHTML = vm.header;

        let calendar = document.createElement("div");
            calendar.setAttribute("id", "calendar_"+vm.id);
            calendar.setAttribute("class", "calendar");
            calendar.style.display = "none";

        calendar.appendChild(mainHeader);

        let inputStart = document.createElement("input");
        inputStart.setAttribute("type", "text");
        inputStart.setAttribute("id", "input_"+ vm.id+"_start");
        inputStart.setAttribute("name", "startDate");
        inputStart.setAttribute("tagName", "input");
        inputStart.setAttribute("class", "datePickerInput");
        inputStart.setAttribute("calendar", "calendar_"+vm.id);
        inputStart.setAttribute("placeholder", "Select a date");
        inputStart.setAttribute("readonly", "true");
        inputStart.setAttribute("required", "required");

        datePicker.appendChild(inputStart);

        let inputEnd = document.createElement("input");
        inputEnd.setAttribute("type", "text");
        inputEnd.setAttribute("id", "input_"+ vm.id+"_end");
        inputEnd.setAttribute("name", "endDate");
        inputEnd.setAttribute("tagName", "input");
        inputEnd.setAttribute("class", "datePickerInput");
        inputEnd.setAttribute("calendar", "calendar_"+vm.id);
        inputEnd.setAttribute("placeholder", "Select a date");
        inputEnd.setAttribute("readonly", "true");
        inputEnd.setAttribute("required", "required");

        datePicker.appendChild(inputEnd);

        let calendarHeaderContainer = document.createElement("div");
        calendarHeaderContainer.setAttribute("class","calendarHeaderContainer");
        let prevButton = document.createElement("button");
            prevButton.setAttribute("type","button");
            prevButton.setAttribute("id", "prevButton_"+vm.id);
            prevButton.innerHTML = "<";

        let nextButton = document.createElement("button");
            nextButton.setAttribute("type","button");
            nextButton.setAttribute("id", "nextButton_"+vm.id);
            nextButton.innerHTML = ">";

        calendarHeaderContainer.appendChild(prevButton);

        let calendarHeader = document.createElement("div");
            calendarHeader.setAttribute("id", "calendar_header_"+vm.id);
            calendarHeader.setAttribute("class", "calendar_header");
            calendarHeader.innerHTML = vm.header;

        calendarHeaderContainer.appendChild(calendarHeader);
        calendarHeaderContainer.appendChild(nextButton);

        let calendarTable = document.createElement("table");
            calendarTable.setAttribute("id", "calendar_body_"+vm.id);

        let calendarTableBody = calendarTable.createTBody();


        let calendarTableHeader = calendarTable.createTHead();
        calendarTableHeader.classList.add("daysOfTheMonth");


            let row = document.createElement("tr");
            for (let j = 0; j < daysOfTheMonth.length; j++) {
                let cell = document.createElement("td");
                cell.setAttribute('id','dayofTheWeek')
                cell.innerHTML = daysOfTheMonth[j];
                row.appendChild(cell);
            }
            calendarTableHeader.appendChild(row);
            this.update(calendarTableBody,calendarHeader,mainHeader)


        calendar.appendChild(calendarHeaderContainer);
        calendar.appendChild(calendarTable);

        datePicker.appendChild(calendar);


        inputStart.addEventListener('click',function(e){
            let calendar = document.getElementById(this.getAttribute("calendar"));
            if(calendar.style.display === "block"){
                calendar.style.display = "none"
            }else{
                calendar.style.display = "block"
            }

        });
        inputEnd.addEventListener('click',function(e){
            let calendar = document.getElementById(this.getAttribute("calendar"));
            if(calendar.style.display === "block"){
                calendar.style.display = "none"
            }else{
                calendar.style.display = "block"
            }
    
        });


        nextButton.addEventListener('click',function(e){
            vm.next(calendarTableBody,calendarHeader,mainHeader);
        });

        prevButton.addEventListener('click',function(e){
            vm.previous(calendarTableBody,calendarHeader,mainHeader);
        });

        this.calendarBody=calendarTableBody;
        this.calendarHeader=calendarHeader;
        this.mainHeader=mainHeader;

    
    }

    dateBoundBlocked(date){
        let count = 0;
        if(this.blockedDates == null)
            return count;
        for(let i = 0; i < this.blockedDates.length ;i++){
            let inicialString = this.blockedDates[i][0] + 'T00:00:00Z';
            let finalString = this.blockedDates[i][1] + 'T00:00:00Z';
            let inicial =  new Date(inicialString);
            let final =  new Date(finalString);
            if(date.getTime() === inicial.getTime() || date.getTime() == final.getTime())
                count++;
        }
        return count;
    }
    dateBoundAvailable(date){
        let count = 0;
        if(this.availableDates == null)
            return count;
        for(let i = 0; i < this.availableDates.length ;i++){
            let inicialString = this.availableDates[i][0] + 'T00:00:00Z';
            let finalString = this.availableDates[i][1] + 'T00:00:00Z';
            let inicial =  new Date(inicialString);
            let final =  new Date(finalString);
            if(date.getTime() === inicial.getTime() || date.getTime() == final.getTime())
                count++;
        }
        return count;
    }
    whichDateBoundBlocked(date){
        if(this.blockedDates == null)
            return -1;
        for(let i = 0; i < this.blockedDates.length ;i++){
            let inicialString = this.blockedDates[i][0] + 'T00:00:00Z';
            let finalString = this.blockedDates[i][1] + 'T00:00:00Z';
            let inicial =  new Date(inicialString);
            let final =  new Date(finalString);
            if(date.getTime() === inicial.getTime())
                return 0;
            if(date.getTime() === final.getTime())
                return 1;
        }
        return -1;
    }
    whichDateBoundAvailable(date){
        if(this.availableDates == null)
            return -1;
        for(let i = 0; i < this.availableDates.length ;i++){
            let inicialString = this.availableDates[i][0] + 'T00:00:00Z';
            let finalString = this.availableDates[i][1] + 'T00:00:00Z';
            let inicial =  new Date(inicialString);
            let final =  new Date(finalString);
            if(date.getTime() === inicial.getTime())
                return 0;
            if(date.getTime() === final.getTime())
                return 1;
        }
        return -1;
    }

    available(date){
        if(this.allowPast == false){
            if(date < yesterday.getTime()){
                return false;
            }
        }
        if(this.blockedDates != null)
            for(let i = 0; i < this.blockedDates.length ;i++){
                let inicialString = this.blockedDates[i][0] + 'T00:00:00Z';
                let finalString = this.blockedDates[i][1] + 'T00:00:00Z';
                let inicial =  new Date(inicialString).getTime();
                let final =  new Date(finalString).getTime();
                if(date >= inicial && date <= final)
                    return false;
            }
        if(this.availableDates != null){
            for(let i = 0; i < this.availableDates.length ;i++){
                let inicialString = this.availableDates[i][0] + 'T00:00:00Z';
                let finalString = this.availableDates[i][1] + 'T00:00:00Z';
                let inicial =  new Date(inicialString).getTime();
                let final =  new Date(finalString).getTime();
                if(date >= inicial && date <= final)
                    return true;
            }
            return false;
        }
        return true;
    }

    allAvailable(startDate,endDate){ //checks if all days are available
        if(this.availableDates==null)
            return true;
        for(let date = new Date(startDate.getTime()); date.getTime() < endDate.getTime(); date.setDate(date.getDate()+1)){

            for(let i = 0; i < this.availableDates.length;i++){
                let nextDate = new Date(date.getTime());
                nextDate.setDate(nextDate.getDate() +1);
                if(!this.inAvailables(date,nextDate))
                    return false;
            }

        }
        return true;
    }
    inAvailables(date1,date2){
        if(this.allowPast == false){
            if(date1.getTime() < yesterday.getTime() || date2.getTime() < yesterday.getTime()){
                return false;
            }
        }
        if(this.availableDates != null){
            for(let i = 0; i < this.availableDates.length ;i++){
                let inicialString = this.availableDates[i][0] + 'T00:00:00Z';
                let finalString = this.availableDates[i][1] + 'T00:00:00Z';
                let inicial =  new Date(inicialString).getTime();
                let final =  new Date(finalString).getTime();
                if(date1.getTime() >= inicial && date1.getTime() <= final && date2.getTime() >= inicial && date2.getTime() <= final)
                    return true;
            }
            return false;
        }
        return true;
    }

    overlaps(date1,date2){
        if(this.blockedDates == null)
            return false;
        for(let i = 0; i < this.blockedDates.length ;i++){
            let inicialString = this.blockedDates[i][0] + 'T00:00:00Z';
            let finalString = this.blockedDates[i][1] + 'T00:00:00Z';
            let inicial =  new Date(inicialString);
            let final =  new Date(finalString);

            if(this.allowOverlaps == false)
                if(date1 < inicial && date2 > final || date1>=inicial && date1 <= final || date2>=inicial && date2 <= final)
                    return true;
            if(this.allowOverlaps == true)
                if(date1 < inicial && date2 > final || date1>=inicial && date1 < final || date2>inicial && date2 <= final)
                    return true;
        }
        return false;
    }
    //checks if the range id dates from da1 to da2 overlapes with the range of dates db1 to db2
    overlapsDates(date1,date2,inicial,final){
        if(date1 < inicial && date2 > final || date1>=inicial && date1 <= final || date2>=inicial && date2 <= final)
            return true;
        return false;
    }
    
    addBlocked(dates){
        this.blockedDates.push(dates);
    }
    addAvailable(dates){
        this.availableDates.push(dates);
    }
    resetDates(){
        this.startDate = null;
        this.endDate = null;
        document.getElementById("input_"+ this.id+"_start").value = null;
        document.getElementById("input_"+ this.id+"_end").value = null;
        this.update(this.calendarBody,this.calendarHeader,this.mainHeader);
    }
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
function createAllCalendars(blockedDates , availableDates){
    var datePickers = document.getElementsByTagName("myDatePicker");
    for ( var x = 0; x < datePickers.length; x++) {
        var allowOverlaps = datePickers[x].getAttribute('allowOverlaps');
        var allowPast = datePickers[x].getAttribute('allowPast');
        let calendar = new Calendar(x, currentYear, currentMonth ,allowOverlaps, blockedDates , availableDates,allowPast);
        calendar.createPicker(datePickers[x]);
    }
}
function createCalendar(blockedDates , availableDates){
    var datePickers = document.getElementsByTagName("myDatePicker");
    var allowOverlaps = datePickers[0].getAttribute('allowOverlaps');
    var allowPast = datePickers[0].getAttribute('allowPast');
    let calendario = new Calendar(0, currentYear, currentMonth ,allowOverlaps, blockedDates , availableDates,allowPast);
    calendario.createPicker(datePickers[0]);
    calendarioRef = calendario;
}