def format_date(date) :
    pieces = date.split("/")
    year = "20" + pieces[2]
    if (len(pieces[1]) == 1) :
        month = "0" + pieces[1]
    else :
        month = pieces[1]
    if (len(pieces[0]) == 1) :
        day = "0" + pieces[0]
    else :
        day = pieces[0]
    result = year + "-" + month + "-" + day
    
    return result        



f = open('grdsformatted.csv', 'r')
o = open('sql.txt', 'a')
count = 0
sqllines = []
for line in f :
    cols = line.split(',')
    daid = str(cols[0])
    auth = ""
    desc = str(cols[4]).replace("!!", ",")
    rtp = str(cols[5]).replace("!!", ",")
    func = str(cols[1]).replace("!!", ",")
    act = str(cols[2]).replace("!!", ",")
    clas = str(cols[3]).replace("!!", ",")
    date = str(cols[6].replace("!!", ","))

    sqlline = "INSERT INTO `grds_data` (`DAID`, `Author ID`, `Description`, `RTP`, `Function`, `Activity`, `Class`, `Last Update`) VALUES ('" + daid + "', NULL, '" + desc + "', '" + rtp + "', '" + func + "', '" + act + "', '" + clas + "', '" + date + "');\n\n"
    o.write(sqlline)
                           
        
#for thing in things :
#    o.write(thing + "\n")
#
#print (len(things)-1)
