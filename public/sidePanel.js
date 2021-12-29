var panelOpened = false;

var mainBody = document.getElementById("testSSL");
if (!mainBody) {
  var mainBody = document.getElementById("lighthouse");
}
if (!mainBody) {
  var mainBody = document.getElementById("monitorsView");
}

var panel = document.getElementById("sidePanel");
var panelTitle = document.getElementById("panelTitle");
var panelSeverity = document.getElementById("panelSeverity");
var panelDescr = document.getElementById("panelDescr");
var panelAdviceTitle = document.getElementById("panelAdviceTitle");
var panelAdvice = document.getElementById("panelAdvice");
var lastCaller;

function closeSidePanel() {
  if (panelOpened) {
    panel.classList.remove("panelOpen");
    mainBody.classList.remove("mainBodyReduced");
    lastCaller.classList.remove("monitorOnSidePanel");
    panelOpened = false;
  }
}

function openSidePanel(label, severity, description, problem) {
  var caller = event.currentTarget;

  if (!panelOpened) {
    panel.classList.add("panelOpen");
    mainBody.classList.add("mainBodyReduced");
    panelOpened = true;
  }
  panelTitle.innerHTML = label;
  panelDescr.innerHTML = description;
  panelAdvice.innerHTML = problem;
  panelSeverity.innerHTML = severity;
  panelSeverity.className = severity;

  if (problem == '') {
    panelAdviceTitle.innerHTML = '';
  } else {
    panelAdviceTitle.innerHTML = 'What should I do?';
  }

  if (lastCaller) {
    lastCaller.classList.remove("monitorOnSidePanel");
  }
  caller.classList.add("monitorOnSidePanel");



  lastCaller = caller;
}
