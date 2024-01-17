let inputWebhook = ""; //Your webhook


/**@type {Array<SalesPlan>} */
let formData = [];



const repostListFieldSet =
{
    userId: "PROPERTY_116",
    plannedSaleAmount: "PROPERTY_118"
}

/**
 * @typedef SalesPlan
 * @property {number} userId
 * @property {number} summ
 */



let showPlanButtons = document.getElementsByTagName("button");
let plan = document.querySelectorAll(".plan");
for (let i = 0; i < showPlanButtons.length; i++)
{
    showPlanButtons[i].addEventListener("click", () => {
        let plan = document.querySelectorAll(".ui-page-slider-workarea");
        for(let j = 0; j < plan.length; j++)
        {
            if (i != j)
            {
                plan[j].hidden = true
            }
        }
        plan = document.querySelectorAll(".ui-page-slider-workarea")[i];
        if (plan.hidden == true)
        {
            plan.hidden = false
        }
        else
        {
            plan.hidden = true
        }
    })
}

for (let i = 0; i < plan.length; i++)
{
    let switch_plan_settings = false;
const inputWebhook = ""; //Your webhook
let button_plan_settings = plan[i].querySelectorAll(".report-visualconstructor-properties-in-heed-button")[0]
let closeIcon = plan[i].querySelectorAll(".popup-window-close-icon.popup-window-titlebar-close-icon")[0]
let cancelButton = plan[i].querySelectorAll(".popup-window-button.popup-window-button-link.popup-window-button-link-cancel")[0]
button_plan_settings.addEventListener("click", setPlan);
closeIcon.addEventListener("click", closeSetPlanWindow);
cancelButton.addEventListener("click", closeSetPlanWindow);


function setPlan(){
    let quarter = plan[i].querySelectorAll(".crm-start-target-month-title")[0].textContent.split(" ")
    let popup_plan_settings = plan[i].querySelectorAll(".popup-window.popup-window-with-titlebar.popup-window-fixed-width")[0]
    if (switch_plan_settings == false) {
        let existingPlanOfUsers = plan[i].querySelectorAll(".crm-start-row")[1]
        let planOfUser = existingPlanOfUsers.querySelectorAll(".crm-start-graph-row")
        let existingPlanForUsers_avatar = existingPlanOfUsers.querySelectorAll(".crm-start-graph-title-avatar")
        for (let j = 0; j < planOfUser.length; j++) {
            let userName = planOfUser[j].querySelectorAll(".crm-start-graph-title-link")[0].textContent
            let planSumByUser = planOfUser[j].querySelectorAll(".crm-start-graph-total-sum")[0].textContent
            planSumByUser = planSumByUser.split(" ")
            let allSelectedUsers = plan[i].querySelectorAll(".crm-start-popup-users")[0]
            // Создаем новый элемент div
            var newElement = document.createElement("div");
            plan[i].appendChild(newElement);

            // Устанавливаем классы и атрибуты для нового элемента
            newElement.className = "crm-start-popup-row";
            newElement.setAttribute("data-new-class", "crm-start-popup-row-new");
            newElement.setAttribute("data-remove-class", "crm-start-popup-row-remove");
            newElement.setAttribute("data-inactive-class", "crm-start-popup-row-inactive");
            newElement.setAttribute("aqua_id", planOfUser[j].getAttribute("aqua_id"))

            // Создаем вложенные элементы и устанавливаем их содержимое и атрибуты
            var personalDiv = document.createElement("div");
            personalDiv.className = "crm-start-popup-personal";
            plan[i].appendChild(personalDiv)

            var personalTitleDiv = document.createElement("div");
            personalTitleDiv.className = "crm-start-popup-personal-title";

            var titleWrapperDiv = document.createElement("div");
            titleWrapperDiv.className = "crm-start-popup-personal-title-wrapper";

            var avatarDiv = document.createElement("div");
            avatarDiv.className = "crm-start-popup-personal-title-avatar";
            avatarDiv.style = existingPlanForUsers_avatar[j].getAttribute("style")

            var infoDiv = document.createElement("div");
            infoDiv.className = "crm-start-popup-personal-title-info";

            var nameSpan = document.createElement("span");
            nameSpan.className = "crm-start-popup-personal-title-name";
            nameSpan.setAttribute("data-role", "user-name");
            nameSpan.textContent = userName;

            var positionSpan = document.createElement("span");
            positionSpan.className = "crm-start-popup-personal-title-position";
            positionSpan.setAttribute("data-role", "user-title");

            var personalContentDiv = document.createElement("div");
            personalContentDiv.className = "crm-start-popup-personal-content";

            var inputElement = document.createElement("input");
            inputElement.type = "text";
            inputElement.className = "crm-start-popup-input";
            inputElement.setAttribute("data-role", "user-target");
            inputElement.placeholder = "Например: 50 000";
            inputElement.name = "target_goal[48]";
            inputElement.value = planSumByUser[0]

            var removeElement = document.createElement("div");
            removeElement.className = "crm-start-popup-personal-remove";
            removeElement.setAttribute("data-role", "user-remove");

            // Добавляем созданные элементы в DOM в нужной иерархии
            newElement.appendChild(personalDiv);
            newElement.appendChild(removeElement);
            personalDiv.appendChild(personalTitleDiv);
            personalTitleDiv.appendChild(titleWrapperDiv);
            titleWrapperDiv.appendChild(avatarDiv);
            titleWrapperDiv.appendChild(infoDiv);
            infoDiv.appendChild(nameSpan);
            infoDiv.appendChild(positionSpan);
            personalDiv.appendChild(personalContentDiv);
            personalContentDiv.appendChild(inputElement);

            allSelectedUsers.appendChild(newElement);
        }
        let removeUser = plan[i].querySelectorAll(".crm-start-popup-personal-remove")
        let submitButton = plan[i].querySelectorAll(".webform-small-button.webform-small-button-accept")[0]
        let currentQuarter = plan[i].querySelectorAll("td")[1]
        let selectedQuarter = currentQuarter.querySelectorAll(".crm-start-dropdown-text")[0]
        let currentYear = plan[i].querySelectorAll("td")[2]
        let switch_quarterList = false
        let closeIcon = plan[i].querySelectorAll(".popup-window-close-icon.popup-window-titlebar-close-icon")[0]
        let cancelButton = plan[i].querySelectorAll(".popup-window-button.popup-window-button-link.popup-window-button-link-cancel")[0]
        selectedQuarter.textContent = quarter;
        closeIcon.addEventListener("click", closeSetPlanWindow)
        cancelButton.addEventListener("click", closeSetPlanWindow)

        let switch_yearList = false

        currentYear.addEventListener("click", () => {
            let yearList = plan[i].querySelectorAll(".popup-window")[plan[i].querySelectorAll(".popup-window").length - 1]
            if (switch_yearList == false) {
                yearList.style.removeProperty("display")
                let yearOption = yearList.querySelectorAll(".menu-popup-item.menu-popup-no-icon")
                switch_yearList = true
                for (let j = 0; j < yearOption.length; j++) {
                    yearOption[j].addEventListener("click", () => {

                        let currentYearText = currentYear.querySelectorAll(".crm-start-dropdown-text")[0]
                        currentYearText.textContent = yearOption[j].children[1].textContent
                        yearList.style.display = "none"
                        switch_yearList = false
                    })
                }
            }
            else {
                yearList.style.display = "none"
                switch_yearList = false
            }
        })
        for (let j = 0; j < removeUser.length; j++) {
            removeUser[j].addEventListener("click", () => {
                removeUser[j].parentNode.remove()
            })
        }
        submitButton.addEventListener("click", formSubmit)

        popup_plan_settings.style.removeProperty("display")
        let current_type_of_plan = plan[i].querySelectorAll(".crm-start-popup-row-content")[2]
        let addUser_button = plan[i].querySelectorAll(".crm-start-popup-row.crm-start-popup-row-border")[3]
        let switch_addUser = false
        let switch_type_of_plan = false
        addUser_button.addEventListener("click", addUser)

        function addUser()
        {
            if (switch_addUser == false) {
                let popup_users_list = plan[i].querySelectorAll(".popup-window.bx-finder-popup.bx-finder-v2")[0]
                popup_users_list.style.removeProperty("display")
                let closeIcon_users = plan[i].querySelectorAll(".popup-window-close-icon")[1]
                let user_list_components = plan[i].querySelectorAll(".bx-finder-groupbox-content")[0]
                closeIcon_users.addEventListener("click", closeAddUsersListWindow);
                showUsersByDepartments();
                showUsersByCategory()






                for (let j = 0; j < user_list_components.children.length; j++) {
                    const index = j;
                    let userName = user_list_components.children[j].children[2].children[0].textContent;
                    user_list_components.children[j].addEventListener("click", addUsersPerformation);
                }

                switch_addUser = true
            }
            else {
                let popup_users_list = plan[i].querySelectorAll(".popup-window.bx-finder-popup.bx-finder-v2")[0]
                popup_users_list.style.display = "none"
                switch_addUser = false
            }
            addUser_button.removeEventListener("click", addUser)
        }

        current_type_of_plan.addEventListener("click", () => {
            if (switch_type_of_plan == false) {
                let list_types_of_plan = plan[i].querySelectorAll(".popup-window")[1];
                list_types_of_plan.style.removeProperty("display")
                switch_type_of_plan = true
            }
            else {
                let list_types_of_plan = plan[i].querySelectorAll(".popup-window")[1];
                list_types_of_plan.style.display = "none"
                switch_type_of_plan = false
            }
        })
        switch_plan_settings = true
    }
    button_plan_settings.removeEventListener("click",  setPlan);
}

function addUsers(param1, param2, param3) {
    param3 = param3.split(" ")
    param3 = param3.join("%20")
    let allSelectedUsers = plan[i].querySelectorAll(".crm-start-popup-users")[0]
    // Создаем новый элемент div
    var newElement = document.createElement("div");

    // Устанавливаем классы и атрибуты для нового элемента
    newElement.className = "crm-start-popup-row";
    newElement.setAttribute("data-new-class", "crm-start-popup-row-new");
    newElement.setAttribute("data-remove-class", "crm-start-popup-row-remove");
    newElement.setAttribute("data-inactive-class", "crm-start-popup-row-inactive");
    newElement.setAttribute("aqua_id", param2)

    // Создаем вложенные элементы и устанавливаем их содержимое и атрибуты
    var personalDiv = document.createElement("div");
    personalDiv.className = "crm-start-popup-personal";

    var personalTitleDiv = document.createElement("div");
    personalTitleDiv.className = "crm-start-popup-personal-title";

    var titleWrapperDiv = document.createElement("div");
    titleWrapperDiv.className = "crm-start-popup-personal-title-wrapper";

    var avatarDiv = document.createElement("div");
    avatarDiv.style.backgroundImage = `url(${param3})`
    avatarDiv.className = "crm-start-popup-personal-title-avatar";

    var infoDiv = document.createElement("div");
    infoDiv.className = "crm-start-popup-personal-title-info";

    var nameSpan = document.createElement("span");
    nameSpan.className = "crm-start-popup-personal-title-name";
    nameSpan.setAttribute("data-role", "user-name");
    nameSpan.textContent = param1;

    var positionSpan = document.createElement("span");
    positionSpan.className = "crm-start-popup-personal-title-position";
    positionSpan.setAttribute("data-role", "user-title");

    var personalContentDiv = document.createElement("div");
    personalContentDiv.className = "crm-start-popup-personal-content";

    var inputElement = document.createElement("input");
    inputElement.type = "text";
    inputElement.className = "crm-start-popup-input";
    inputElement.setAttribute("data-role", "user-target");
    inputElement.placeholder = "Например: 50 000";
    inputElement.name = "target_goal[48]";

    var removeElement = document.createElement("div");
    removeElement.className = "crm-start-popup-personal-remove";
    removeElement.setAttribute("data-role", "user-remove");


    newElement.appendChild(personalDiv);
    newElement.appendChild(removeElement);
    personalDiv.appendChild(personalTitleDiv);
    personalTitleDiv.appendChild(titleWrapperDiv);
    titleWrapperDiv.appendChild(avatarDiv);
    titleWrapperDiv.appendChild(infoDiv);
    infoDiv.appendChild(nameSpan);
    infoDiv.appendChild(positionSpan);
    personalDiv.appendChild(personalContentDiv);
    personalContentDiv.appendChild(inputElement);

    allSelectedUsers.appendChild(newElement);
    removeElement.addEventListener("click", () => {
        removeElement.parentNode.remove()
    })
}

function loadPlanSalesData() {
    let inputValidation = checkInput()
    if (inputValidation == false) {
        return false
    }
    let result;
    let form = plan[i].querySelectorAll(".popup-window-content")[0]
    let usersAvatar = form.querySelectorAll(".crm-start-popup-personal-title-avatar")
    let users = form.querySelectorAll(".crm-start-popup-personal-title-name")
    let users_id = [];
    let plannedSaleAmount = form.querySelectorAll(".crm-start-popup-input");
    let crmStartRow = plan[i].querySelectorAll(".crm-start-row")[1];
    let quarter = plan[i].querySelectorAll(".crm-start-dropdown-text")[1].textContent

    let url = inputWebhook + "lists.element.get";
    let params =
    {
        IBLOCK_TYPE_ID: "lists",
        IBLOCK_ID: 30,
        FILTER: {
            PROPERTY_122: quarter
        }
    }
    let queryToBitrix = new XMLHttpRequest();
    queryToBitrix.open("POST", url, false);
    queryToBitrix.setRequestHeader("Content-Type", "application/json");
    queryToBitrix.send(JSON.stringify(params));
    if (queryToBitrix.status != 200) {
        console.log("ERROR: ")
        console.error(queryToBitrix);
        return;
    }

    /**@type {Array<SalesPlan>} */
    let formData = [];

    let resultFromBitrix = JSON.parse(queryToBitrix.responseText);
    for (let j = 0; j < resultFromBitrix.result.length; j++) {
        let listElement = resultFromBitrix.result[j];

        let userId = 0;
        let innerArray = listElement[repostListFieldSet.userId];
        for (let key in innerArray) { userId = Number(innerArray[key]); break; }

        let summ = 0;
        innerArray = listElement[repostListFieldSet.plannedSaleAmount];
        for (let key in innerArray) { summ = Number(innerArray[key]); break; }

        /**@type {SalesPlan} */
        // let newElement =
        // {
        //     summ: summ,
        //     userId: userId
        // }
        let newElement = [summ, userId];
        formData.push(newElement);
    }

    sumOfPlan = 0;
    for (let j = 0; j < formData.length; j++) {
        const value = formData[j];
        const rowDiv = document.createElement("div");
        rowDiv.classList.add("crm-start-graph-row");
        rowDiv.setAttribute("aqua_id", value[1])
        rowDiv.setAttribute("onclick", 'showDiv(this)')

        const headDiv = document.createElement("div");
        headDiv.classList.add("crm-start-graph-head", "crm-start-graph-head-dropdown");
        headDiv.setAttribute("data-role", "user-row");
        headDiv.setAttribute("data-open-class", "crm-start-graph-head-open");
        headDiv.setAttribute("data-inactive-class", "crm-start-graph-head-inactive");

        const titleDiv = document.createElement("div");
        titleDiv.classList.add("crm-start-graph-title");

        const avatarDiv = document.createElement("div");
        avatarDiv.classList.add("crm-start-graph-title-avatar");
        avatarDiv.setAttribute("data-role", "user-photo");
        if (usersAvatar[j]) {
            avatarDiv.style = usersAvatar[j].getAttribute("style");
          }

        const userDiv = document.createElement("div");
        userDiv.classList.add("crm-start-graph-title-user");

        const userNameSpan = document.createElement("span");
        userNameSpan.classList.add("crm-start-graph-title-link");
        userNameSpan.setAttribute("data-role", "user-name");
        userNameSpan.textContent = users[j].textContent;//key;

        const userPositionSpan = document.createElement("span");
        userPositionSpan.classList.add("crm-start-graph-title-position");
        userPositionSpan.setAttribute("data-role", "user-title");

        const wrapperDiv = document.createElement("div");
        wrapperDiv.classList.add("crm-start-graph-wrapper");

        const progressDiv = document.createElement("div");
        progressDiv.classList.add("crm-start-graph-progress");
        progressDiv.setAttribute("data-role", "user-progress");
        progressDiv.setAttribute("data-more-class", "crm-start-graph-progress-more");

        const progressLineDiv = document.createElement("div");
        progressLineDiv.classList.add("crm-start-graph-progress-line");
        progressLineDiv.setAttribute("style", "width: 0%;");
        progressLineDiv.setAttribute("data-role", "user-progress-line");

        const progressTotalDiv = document.createElement("div");
        progressTotalDiv.classList.add("crm-start-graph-progress-total");
        progressTotalDiv.setAttribute("data-role", "user-progress-line-value");
        progressTotalDiv.textContent = "64";

        const totalSumDiv = document.createElement("div");
        totalSumDiv.classList.add("crm-start-graph-total-sum");
        totalSumDiv.setAttribute("data-role", "user-target");
        totalSumDiv.innerHTML = `${value[0]} <span>тенге</span>`;
        sumOfPlan += parseInt(value[0])

        // Добавляем элементы в DOM
        progressDiv.appendChild(progressLineDiv);
        progressDiv.appendChild(progressTotalDiv);

        userDiv.appendChild(userNameSpan);
        userDiv.appendChild(userPositionSpan);

        titleDiv.appendChild(avatarDiv);
        titleDiv.appendChild(userDiv);

        wrapperDiv.appendChild(progressDiv);
        wrapperDiv.appendChild(totalSumDiv);

        headDiv.appendChild(titleDiv);
        headDiv.appendChild(wrapperDiv);

        rowDiv.appendChild(headDiv);


        var container = document.createElement("div");
        container.className = "crm-start-graph-content";
        container.setAttribute("data-role", "user-target-details");
        container.setAttribute("data-open-class", "crm-start-graph-content-open");

        var userPlanDiv = document.createElement("div");
        userPlanDiv.className = "crm-start-graph-user-plan";

        var item1 = document.createElement("div");
        item1.className = "crm-start-graph-user-plan-item";


        var title1 = document.createElement("span");
        title1.className = "crm-start-graph-user-plan-title";
        title1.textContent = "Выполнено";


        var total1 = document.createElement("div");
        total1.className = "crm-start-graph-user-plan-total";
        total1.setAttribute("data-role", "user-target-current");
        total1.innerHTML = `0<span> тенге</span>`;

        var item2 = document.createElement("div");
        item2.className = "crm-start-graph-user-plan-item";

        // Создаем элемент <span> с классом "crm-start-graph-user-plan-title" и текстом "Осталось"
        var title2 = document.createElement("span");
        title2.className = "crm-start-graph-user-plan-title";
        title2.textContent = "Осталось";

        // Создаем элемент <div> с классом "crm-start-graph-user-plan-total" и атрибутом "data-role" равным "user-target-remaining"
        var total2 = document.createElement("div");
        total2.className = "crm-start-graph-user-plan-total";
        total2.setAttribute("data-role", "user-target-remaining");
        total2.innerHTML = `${value[0]} <span> тенге</span>`;

        var item3 = document.createElement("div");
        item3.className = "crm-start-graph-user-plan-item";

        // Создаем элемент <span> с классом "crm-start-graph-user-plan-title" и текстом "Выполнение плана"
        var title3 = document.createElement("span");
        title3.className = "crm-start-graph-user-plan-title";
        title3.textContent = "Выполнение плана";

        // Создаем элемент <div> с классом "crm-start-graph-user-plan-total"
        var total3 = document.createElement("div");
        total3.className = "crm-start-graph-user-plan-total";

        // Создаем элемент <span> с классом "crm-start-graph-user-plan-sum" и атрибутом "data-role" равным "user-target-effective"
        var sum = document.createElement("span");
        sum.className = "crm-start-graph-user-plan-sum";
        sum.setAttribute("data-role", "user-target-effective");
        sum.textContent = "0";

        // Создаем элемент <span> с классом "crm-start-graph-user-plan-symbol" и текстом "%"
        var symbol = document.createElement("span");
        symbol.className = "crm-start-graph-user-plan-symbol";
        symbol.textContent = "%";

        // Добавляем элементы в иерархию DOM
        total3.appendChild(sum);
        total3.appendChild(symbol);

        // Добавляем "title3" и "total3" в "item3"
        item3.appendChild(title3);
        item3.appendChild(total3);
        item2.appendChild(title2);
        item2.appendChild(total2);
        item1.appendChild(title1);
        item1.appendChild(total1);
        userPlanDiv.appendChild(item1);
        userPlanDiv.appendChild(item2);
        userPlanDiv.appendChild(item3);


        container.appendChild(userPlanDiv);

        rowDiv.appendChild(container);
        crmStartRow.appendChild(rowDiv);

    }
}

function formSubmit() {
    let inputValidation = checkInput()
    if (inputValidation == false) {
        return false
    }
    let result;
    let form = plan[i].querySelectorAll(".popup-window-content")[0]
    let users = form.querySelectorAll(".crm-start-popup-personal-title-name")
    let users_id = [];
    //users.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute("aqua_id")
    let usersAvatar = form.querySelectorAll(".crm-start-popup-personal-title-avatar")
    let plannedSaleAmount = form.querySelectorAll(".crm-start-popup-input");
    let crmStartRow = plan[i].querySelectorAll(".crm-start-row")[1];
    let quarter = plan[i].querySelectorAll("td")[1];
    let quarterValue = quarter.querySelectorAll(".crm-start-dropdown-text")[1].textContent;
    let year = plan[i].querySelectorAll('td')[2];
    let yearValue = year.querySelectorAll('.crm-start-dropdown-text')[0].textContent;
    let firstDayOfQuarter = plan[i].querySelectorAll(".crm-start-graph-month-scale-item-first")[0];
    let lastDayOfQuarter = plan[i].querySelectorAll(".crm-start-graph-month-scale-item-last")[0];
    switch (quarterValue) {
        case 'I':
            firstDayOfQuarter.textContent = '1 января';
            lastDayOfQuarter.textContent = '31 марта'
            break
        case 'II':
            firstDayOfQuarter.textContent = '1 апреля';
            lastDayOfQuarter.textContent = '30 июня'
            break
        case 'III':
            firstDayOfQuarter.textContent = '1 июля';
            lastDayOfQuarter.textContent = '30 сентября'
            break
        case 'IV':
            firstDayOfQuarter.textContent = '1 октября';
            lastDayOfQuarter.textContent = '31 декабря'
            break
    }

    for (let j = 0; j < users.length; j++) {
        users_id.push(users[j].parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute("aqua_id"));
    }



    let existingPlans = [];

    let url = inputWebhook + "lists.element.get";
    let params =
    {
        IBLOCK_TYPE_ID: "lists",
        IBLOCK_ID: 30,
        FILTER: {
            PROPERTY_122: quarterValue
        }
    }
    let queryToBitrix = new XMLHttpRequest();
    queryToBitrix.open("POST", url, false);
    queryToBitrix.setRequestHeader("Content-Type", "application/json");
    queryToBitrix.send(JSON.stringify(params));
    if (queryToBitrix.status != 200) {
        console.log("ERROR: ")
        console.error(queryToBitrix);
        return;
    }
    let resultFromBitrix = JSON.parse(queryToBitrix.responseText);
    resultFromBitrix = resultFromBitrix.result
    let idElementsFromBitrix = [];
    for (let j = 0; j < resultFromBitrix.length; j++) {
        idElementsFromBitrix.push(resultFromBitrix[j]['CODE'])
    }


    if (idElementsFromBitrix.length > 0) {
        url = inputWebhook + "lists.element.delete";
        for (let j = 0; j < idElementsFromBitrix.length; j++) {
            params =
            {
                IBLOCK_TYPE_ID: "lists",
                IBLOCK_ID: 30,
                ELEMENT_CODE: idElementsFromBitrix[j]
            }

            queryToBitrix = new XMLHttpRequest();
            queryToBitrix.open("POST", url, false);
            queryToBitrix.setRequestHeader("Content-Type", "application/json");
            queryToBitrix.send(JSON.stringify(params));
            if (queryToBitrix.status != 200) {
                console.log("ERROR: ")
                console.error(queryToBitrix);
                return;
            }
        }
    }




    for (let j = 0; j < users.length; j++) {
        let currentMiliseconds = new Date().toUTCString();
        let params =
        {
            IBLOCK_TYPE_ID: "lists",
            IBLOCK_ID: 30,
            ELEMENT_CODE: 'element_' + Date.now(),
            FIELDS:
            {
                // There have to be name of columns in universal list
                "NAME": `Запись ${j + 1}`,
                "PROPERTY_116": users_id[j],
                "PROPERTY_118": plannedSaleAmount[j].value,
                "PROPERTY_122": quarterValue,
                "PROPERTY_124": yearValue,
                "PROPERTY_126": usersAvatar[j].style.backgroundImage.split('"')[1]
            }
        }
        let url = inputWebhook + "lists.element.add";
        let queryToBitrix = new XMLHttpRequest();
        queryToBitrix.open("POST", url, false);
        queryToBitrix.setRequestHeader("Content-Type", "application/json");
        queryToBitrix.send(JSON.stringify(params));
        if (queryToBitrix.status != 200) {
            console.error(queryToBitrix);
        }
        // formData[users[i].textContent] = [plannedSaleAmount[i].value, users_id[i]];
    }
    while (crmStartRow.firstChild) {
        crmStartRow.removeChild(crmStartRow.firstChild);
    }
    loadPlanSalesData();
    let selectedUsers_id = {
        quarter: quarterValue,
        year: yearValue,
        id: users_id
    }
    const phpFileUrl = './getDeals.php'; // full link of the getDeals.php file
    const xhr = new XMLHttpRequest();

    xhr.open('POST', phpFileUrl, false);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                result = data
            } else {
                console.error('Network response was not ok');
            }
        }
    };

    xhr.send(JSON.stringify(selectedUsers_id));
    let sumOfMargin = 0;
    for (const key in result) {
        if (result.hasOwnProperty(key)) {
            sumOfMargin += result[key];
        }
    }
    let usersPlan = plan[i].querySelectorAll(".crm-start-row")[1];
    let planForPeriod = plan[i].querySelectorAll(".crm-start-target-month-title")[0];
    let allCompletedPlan = plan[i].querySelectorAll(".crm-start-row-result-item-total")[0]
    let remainderOfPlan = plan[i].querySelectorAll(".crm-start-row-result-item-total")[1]
    let percentOfAllCompletedPlan = plan[i].querySelectorAll(".crm-start-row-result-item-total")[2]
    let percentageOfAll = plan[i].querySelectorAll(".crm-start-graph-progress-total")[plan[i].querySelectorAll(".crm-start-graph-progress-total").length - 1]
    for (let j = 0; j < usersPlan.children.length; j++)
    {
        for (const key in result) {
            if (usersPlan.children[j].getAttribute("aqua_id") == key) {
                let remainingPlanByUser = usersPlan.children[j].querySelectorAll(".crm-start-graph-user-plan-total")[1]
                let executionOfThePlanByUsers = usersPlan.children[j].querySelectorAll(".crm-start-graph-user-plan-total")[0]
                let executionOfThePlanByUsersPercentage = usersPlan.children[j].querySelectorAll(".crm-start-graph-user-plan-sum")[0]
                executionOfThePlanByUsersPercentage.textContent = Math.round(parseInt(result[key])/parseInt(remainingPlanByUser.textContent.split(" ")[0]) * 100)
                executionOfThePlanByUsers.textContent = result[key] + ' тенге'
                remainingPlanByUser.textContent = parseInt(remainingPlanByUser.textContent.split(" ")[0]) - parseInt(result[key]) + ' тенге'

            }
        }
    }
    planForPeriod.textContent = `${quarterValue} квартал ${yearValue}`


    allCompletedPlan.textContent = sumOfMargin
    if (sumOfPlan - sumOfMargin <= 0) {
        remainderOfPlan.textContent = 0
    }
    else {
        remainderOfPlan.textContent = sumOfPlan - sumOfMargin
    }

    percentOfAllCompletedPlan.textContent = `${Math.round((sumOfMargin / sumOfPlan) * 100)}%`
    let totalProgressLine = plan[i].querySelectorAll(".crm-start-graph-month-progress-line")[0]
    if (Math.round((sumOfMargin / sumOfPlan) * 100) >= 100) {
        totalProgressLine.style.width = "100%"
        percentageOfAll.style.position = 'absolute';
        percentageOfAll.style.zIndex = 1000;
        percentageOfAll.style.right = 0
    }
    else if (Math.round((sumOfMargin / sumOfPlan) * 100) > 90) {
        totalProgressLine.style.width = `${Math.round((sumOfMargin / sumOfPlan) * 100)}%`
        percentageOfAll.style.position = 'absolute';
        percentageOfAll.style.zIndex = 1000;
        percentageOfAll.style.right = 0
    }
    else {
        totalProgressLine.style.width = `${Math.round((sumOfMargin / sumOfPlan) * 100)}%`
    }
    percentageOfAll.textContent = Math.round((sumOfMargin / sumOfPlan) * 100).toString()
    for (let j = 0; j < crmStartRow.children.length; j++) {
        if (crmStartRow.children[j].getAttribute("aqua_id") in result) {
            let progressLine = crmStartRow.children[j].querySelectorAll(".crm-start-graph-progress-line")[0]
            let numPercentage = crmStartRow.children[j].querySelectorAll(".crm-start-graph-progress-total")[0]
            let targetSum = crmStartRow.children[j].querySelectorAll(".crm-start-graph-total-sum")[0].textContent
            let progressLinePercentage = Math.round((parseInt(result[crmStartRow.children[j].getAttribute("aqua_id")]) / parseInt(targetSum)) * 100)
            if (progressLinePercentage >= 100) {
                progressLine.style.width = '100%';
                numPercentage.style.position = 'absolute';
                numPercentage.style.zIndex = 1000;
                numPercentage.style.right = 0
            }
            else if (progressLinePercentage > 90) {
                progressLine.style.width = `${progressLinePercentage}%`
                numPercentage.style.position = 'absolute';
                numPercentage.style.zIndex = 1000;
                numPercentage.style.right = 0
            }
            else {
                progressLine.style.width = `${progressLinePercentage}%`
            }
            numPercentage.textContent = progressLinePercentage.toString()
        }
        else {
            let progressLine = crmStartRow.children[j].querySelectorAll(".crm-start-graph-progress-line")[0]
            let numPercentage = crmStartRow.children[j].querySelectorAll(".crm-start-graph-progress-total")[0]
            let progressLinePercentage = '0'
            progressLine.style.width = `${progressLinePercentage}%`
            numPercentage.textContent = progressLinePercentage
        }

    }

    let targetTotal = plan[i].querySelectorAll(".crm-start-target-total")[0]
    targetTotal.textContent = sumOfPlan
}
function checkInput() {
    let usersFromForm = plan[i].querySelectorAll(".crm-start-popup-users")[0]
    let formInput = usersFromForm.querySelectorAll(".crm-start-popup-input")
    for (let j = 0; j < formInput.length; j++) {
        if (formInput[j].value.length == 0) {
            alert("Пожалуйста заполните все поля")
            return false
        }
        else {
            return true
        }
    }
}
function closeSetPlanWindow()
{
        let popup_plan_settings = plan[i].querySelectorAll(".popup-window.popup-window-with-titlebar.popup-window-fixed-width")[0]
        let crm_start_popup_users = popup_plan_settings.querySelectorAll(".crm-start-popup-users")[0]
        let usersOfpopup_plan_settings = crm_start_popup_users.querySelectorAll(".crm-start-popup-row")
        for (let j = 0; j < usersOfpopup_plan_settings.length; j++) {
            usersOfpopup_plan_settings[j].remove()
        }
        popup_plan_settings.style.display = "none"
        button_plan_settings.addEventListener("click",  setPlan)
        closeIcon.removeEventListener("click", closeSetPlanWindow)
        cancelButton.removeEventListener("click", closeSetPlanWindow)
        switch_plan_settings = false
}





function closeAddUsersListWindow()
{
    let popup_users_list = plan[i].querySelectorAll(".popup-window.bx-finder-popup.bx-finder-v2")[0]
    let user_list_components = plan[i].querySelectorAll(".bx-finder-groupbox-content")[0]
    let closeIcon_users = plan[i].querySelectorAll(".popup-window-close-icon")[1]
    for (let j = 0; j < user_list_components.children.length; j++) {
        const index = j;
        user_list_components.children[j].removeEventListener("click", addUsersPerformation);
    }
    popup_users_list.style.display = "none";
    switch_addUser = false;
    closeIcon_users.removeEventListener("click", closeAddUsersListWindow)
    let addUser_button = plan[i].querySelectorAll(".crm-start-popup-row.crm-start-popup-row-border")[3]
    addUser_button.addEventListener("click", addUser)
}



function addUsersPerformation(event) {
    let userName = event.target;
    let user_id;
    switch (userName.className) {
        case "bx-finder-box-item-t7-name":
            user_id = userName.parentNode.parentNode.getAttribute("aqua_id")
            user_avatar = userName.parentNode.parentNode.children[0].children[0].getAttribute("src")
            userName = userName.textContent
            break;
        case "bx-finder-box-item-t7-avatar-img":
            user_id = userName.parentNode.parentNode.getAttribute("aqua_id")
            user_avatar = userName.getAttribute("src");
            userName = userName.parentNode.parentNode
            userName = userName.children[2].children[0].textContent
            break;
        case "bx-finder-box-item-t7 bx-finder-element bx-lm-element-user":
            user_avatar = userName.children[0].children[0].getAttribute("src")
            user_id = userName.getAttribute("aqua_id")
            userName = userName.children[2].children[0].textContent
            break;
        case "bx-finder-box-item-avatar-status":
            user_avatar = userName.parentNode.children[0].getAttribute("src")
            user_id = userName.parentNode.parentNode.getAttribute("aqua_id")
            userName = userName.children[2].children[0].textContent
            break;
    }
    addUsers(userName, user_id, user_avatar)
}



function showDiv(element)
{
    if (element.children[1].classList.contains('crm-start-graph-content-open'))
    {
        element.children[1].classList.remove('crm-start-graph-content-open');
    }
    else
    {
        element.children[1].classList.add('crm-start-graph-content-open');
    }
}




function showUsersByCategory()
{
    let categoryOfUsers = plan[i].querySelectorAll(".bx-finder-box-tab")
    let categoryList = plan[i].querySelectorAll(".bx-finder-box-tabs-content-cell")[0]
    let usersList = categoryList.querySelectorAll(".bx-finder-box-tab-content")
    for (let j = 0; j < categoryOfUsers.length; j++)
    {
        categoryOfUsers[j].addEventListener("click", () => {
            if (categoryOfUsers[j].classList.contains('bx-lm-tab-last'))
            {
                categoryOfUsers[j].classList.add("bx-finder-box-tab-selected")
                categoryOfUsers[j + 1].classList.remove("bx-finder-box-tab-selected")
                usersList[0].classList.add("bx-finder-box-tab-content-selected")
                usersList[1].classList.remove("bx-finder-box-tab-content-selected")
            }
            else if (categoryOfUsers[j].classList.contains('bx-lm-tab-department'))
            {
                categoryOfUsers[j].classList.add("bx-finder-box-tab-selected")
                categoryOfUsers[j - 1].classList.remove("bx-finder-box-tab-selected")
                usersList[1].classList.add("bx-finder-box-tab-content-selected")
                usersList[0].classList.remove("bx-finder-box-tab-content-selected")
            }
        })
    }
}

function addUsersPerformationByDepartment(element)
{
    switch(element.srcElement.className)
    {
        case 'bx-finder-company-department-employee  bx-finder-element':
            user_id = element.srcElement.getAttribute("aqua_id")
            userName = element.srcElement.children[0].children[0].textContent
            user_avatar = element.srcElement.children[1].getAttribute('style')
            regex = /background:url\(([^)]+)\)/;
            user_avatar = user_avatar.match(regex)[1];
            break;
        case 'bx-finder-company-department-employee-name':
            chosenElement = element.srcElement.parentNode.parentNode
            user_id = chosenElement.getAttribute("aqua_id")
            userName = element.srcElement.textContent
            user_avatar = chosenElement.children[1].getAttribute('style')
            regex = /background:url\(([^)]+)\)/;
            user_avatar = user_avatar.match(regex)[1];
            break;
        case 'bx-finder-company-department-employee-info':
            chosenElement = element.srcElement.parentNode
            user_id = chosenElement.getAttribute("aqua_id")
            userName = element.srcElement.children[0].textContent
            user_avatar = chosenElement.children[1].getAttribute('style')
            regex = /background:url\(([^)]+)\)/;
            user_avatar = user_avatar.match(regex)[1];
            break;
        case 'bx-finder-company-department-employee-avatar':
            chosenElement = element.srcElement.parentNode
            user_id = chosenElement.getAttribute("aqua_id")
            userName = chosenElement.children[0].children[0].textContent
            user_avatar = element.srcElement.getAttribute('style')
            regex = /background:url\(([^)]+)\)/;
            user_avatar = user_avatar.match(regex)[1];
            break;
    }
    aqua_id = element.srcElement.getAttribute("aqua_id")
    addUsers(userName, user_id, user_avatar);
}


function showUsersByDepartments()
{
    let departments_button = plan[i].querySelectorAll(".bx-finder-company-department")
    let departments_children = plan[i].querySelectorAll(".bx-finder-company-department-children")
    for (let j = 0; j < departments_button.length; j++)
    {
        departments_button[j].addEventListener("click", () => {
            if (departments_button[j].classList == "bx-finder-company-department")
            {
                departments_button[j].classList.add("bx-finder-company-department-opened")
                departments_children[j].classList.add("bx-finder-company-department-children-opened")
                for(let k = 0; k < departments_children[j].children[0].children.length; k++)
                {
                    departments_children[j].children[0].children[k].addEventListener("click", addUsersPerformationByDepartment)
                }

            }
            else
            {
                departments_button[j].classList.remove("bx-finder-company-department-opened")
                departments_children[j].classList.remove("bx-finder-company-department-children-opened")
                departments_children[j].children[0].children[k].removeEventListener("click", addUsersPerformationByDepartment)
            }
        })
    }
}
}
