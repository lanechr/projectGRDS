
<!doctype html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700|Merriweather:400italic,400' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<title>GRDS - Results</title>
	<script>
		$(document).ready(function() {
		    // Configure/customize these variables.
		    var showChar = 150;  // How many characters are shown by default
		    var ellipsestext = "...";
		    var moretext = "<button>Read More</button>";
		    var lesstext = "<button>Read Less</button>";
		    

		    $('.more').each(function() {
		        var content = $(this).html();
		 
		        if(content.length > showChar) {
		 
		            var c = content.substr(0, showChar);
		            var h = content.substr(showChar, content.length - showChar);
		 
		            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
		 
		            $(this).html(html);
		        }
		 
		    });
		 
		    $(".morelink").click(function(){
		        if($(this).hasClass("less")) {
		            $(this).removeClass("less");
		            $(this).html(moretext);
		        } else {
		            $(this).addClass("less");
		            $(this).html(lesstext);
		        }
		        $(this).parent().prev().toggle();
		        $(this).prev().toggle();
		        return false;
		    });
		});
	</script>
	<script type="text/javascript">
		function findGetParameter(parameterName) {
		    var result = null,
		        tmp = [];
		    var items = window.location.search.substr(1).split("&");
		    for (var index = 0; index < items.length; index++) {
		        tmp = items[index].split("=");
		        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
		    }
		    return result;
		}

		function showHide() {
			var key = findGetParameter('keyword');
			var divi = findGetParameter('division');
			var subDivi = findGetParameter('subDivision');
			var res1 = document.getElementById('result1');
			var res1b = document.getElementById('result1b');
			var res2 = document.getElementById('result2');
			var res3 = document.getElementById('result3');
			var res4 = document.getElementById('result4');
			var res5 = document.getElementById('result5');
			if (key == "asset" || key == "assets" || key == "Asset" || key == "Assets") {
				res2.style.display = 'none';
				res3.style.display = 'none';
				res4.style.display = 'none';
				res5.style.display = 'none';
			} else if (divi == '1') {
				res1.style.display = 'none';
       			res1b.style.display = 'none';
       			res3.style.display = 'none';
				res4.style.display = 'none';
				res5.style.display = 'none';
			} else if (subDivi == '1'){
				res1.style.display = 'none';
       			res1b.style.display = 'none';
       			res2.style.display = 'none';
				res4.style.display = 'none';
				res5.style.display = 'none';
			} else if (key == "1272"){
       			res1.style.display = 'none';
       			res1b.style.display = 'none';
       			res2.style.display = 'none';
       			res3.style.display = 'none';
				res5.style.display = 'none';
			} else {
				res1.style.display = 'none';
       			res1b.style.display = 'none';
       			res2.style.display = 'none';
       			res3.style.display = 'none';
				res4.style.display = 'none';
			}
			return true;
		}
	</script>
</head>
<body class="body-results" onload="showHide();">
	<a href="index.html" class="back-button">Back</a>
	<h1>Search Results</h1>

	<!-- [number] refers to the number of results that are queried on [keyword]
get post method here
	
	<h3>[number] results on [keyword]</h3> -->

	<div class="top-button">
		<button class="top-button">Sort</button>
		<button class="top-button">Filter</button>
	</div>

	<!-- template for one result  search for "1099" EXAMPLE 1-->
	<div class="result-box" id="result1">
		<h2>1099 - Asset and money management</h2>
		
		<p class="more">Records relating to the payment or receipt of money and the financial management of the agency’s assets.
						Includes records, which document the agency’s financial and bank transactions, as well as the management of trusts.
						Records may include, but are not limited to:
 accounting – cash books, ledgers, journals, bank statements, reconciliations, receipt and revenue records, requisition/purchase orders
 annual and periodic financial statements including:
o certified financial statements prepared for abolished agencies in accordance with s.47 and s.48 of the Financial and Performance Management Standard 2009
o certified financial statements prepared for newly formed agencies in accordance with s.44 of the Financial and Performance Management Standard 2009.
 asset/equity management – approvals, asset identification, depreciation, evaluation, losses and write-offs, revaluations, transfers, valuations and verifications
 banking activities – banking accounts, investment and dividend statements, deposit/withdrawal records, electronic funds transfer (EFT) and international money transfers (IMT) transaction records
 contingent assets and liabilities – quarterly reports
 credit card usage, including special purpose facilities such as fuel cards and purchase cards – credit card applications, arrangements (e.g. credit limits, payment terms, benefits, security, etc.) and statements
 debts, overpayments and material losses – includes debt recovery and write-offs
 donations – approvals, notifications, terms & conditions
 fundraising – winning raffle tickets
 non-cash business benefits received by agency staff (e.g. frequent flyer points) – applications and statements
 payment records – includes invoices, cheques and special payments such as ex gratia payments, extra-contractual payments, out of court settlements, court ordered damages and payments requiring Governor-in-Council approval
 user fee setting – approvals, schedule of fees
 receipt of royalty payments
 trust management
 rewards, e.g. reporting vandalism committed on or to agency property.
						
						Main division : FINANCIAL MANAGEMENT
						Sub-division : Accounting
						</p>
	</div>
<!--   SEARCHING FOR  "ANNUAL REPORT" EXAMPLE 5-->
	<div class="result-box" id="result1b">
		<h2>Asset Management</h2>
		<p class="more" >Acquiring, supplying, maintaining, repairing and disposing of moveable assets.
		Moveable assets may include, but are not limited to: vehicles, machinery, plant, equipment, appliances, implements, tools, furniture, furnishings, clothing, chemicals, hardware (including IT), kitchen/cleaning items, medical supplies, stationery and software.
		Excludes the management of buildings, structures and land and the management of moveable assets, required for the delivery of core functions, which have specific retention requirements (e.g. firearms).
		See COMMON ACTIVITIES – Compensation for records relating to compensation/insurance claims for injuries and/or damage/loss of assets.
		See FINANCIAL MANAGEMENT – Accounting for the financial management of moveable assets.
		See PROPERTY MANAGEMENT for the management of buildings, structures or land.
		See WORK HEALTH AND SAFETY – Accidents and Incidents for records relating to work health and safety accidents and incidents that involve agency assets.</p>
	</div>

	<div class="result-box" id="result2">
		<h2>1042 - Reports – significant</h2>
		<p class="more" >Significant reports may include, but are not limited to:
			 strategic level reports relating to the agency’s core functions and performance
			 those with whole-of-government implications.
			Includes whole-of-government reporting performed by agencies that have an overview of other agency’s compliance with legislation.
			Also includes both published and unpublished reports.
			Records may include, but are not limited to:
			 annual reports.

			Main division : Common Activities
					Sub-division : Reporting</p>
	</div>

	<div class="result-box" id="result3">
		<h2>1147 - Agency publications – significant</h2>
		<p class="more" >Master copies of all significant agency publications.
			Includes final version of agency annual report.
			Significant publications may include those that:
			 define the functions of government relating to the government’s jurisdiction and power
			 have whole of government implications
			 generate/involve substantial community or public interest, debate or controversy
			 have social, economic, environmental, cultural, scientific, research or technical significance to the broader community
			 mark major anniversaries or opening of new landmark structures and/or buildings.
		Main division : Information Management
		Sub-division : Publication
		</p>	
	</div>

	<div class="result-box" id="result4">
		<h2>1272 - DRAFTS, WORKING NOTES AND CALCULATIONS </h2>
		<p class="more" >Examples (Records) may include, but are not limited to:
			 drafts, audio recordings and shorthand notes used to prepare other documents
			 drafts which do not proceed and of which no final version is created
			 calculations, statistics or figures
			 personal meeting minutes where a formal record exists
			 editing of spelling and grammar where there are no other significant changes
			 background research
			 unused reference material
			 spreadsheets or word processing documents that have been incorporated into another document.
		</p>
	</div>

	<!-- EXAMPLE 3 SEARCH FOR "Environmental Authority" -->
	<div class="result-box" id="result5">
		<h2>No Results Found</h2>
	</div>
</body>
<html>