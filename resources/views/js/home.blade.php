<script>
    //COMMON HEADERS TO BE USED TO ALL POST,PUT,DELETE request
    let page = 0;
    let certificate_id = 0;
    let diagnosis_index = -1;
    const HEADERS = {
        "Content-Type": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    const DOCTORS = [
        {
            "name": "DR. ANGELIQUE B. ABALO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152123"
        },
        {
            "name": "DR. IRICAR DAWN B. ABARQUEZ",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "119366"
        },
        {
            "name": "DR. LEMUELA EVA A. ABECIA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "120075"
        },
        {
            "name": "DR. EVALAINE MAE A. ABECIA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "145157"
        },
        {
            "name": "DR. HEGINIO C. ABUDA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "101732"
        },
        {
            "name": "DR. JACKIE LOU C. ACHA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "131741"
        },
        {
            "name": "DR. MARRAH A. ACUIN",
            "designation": "MEDICAL OFFICER III",
            "license_no": "146275"
        },
        {
            "name": "DR. JULIE LIZZA MENDOZA-ADLAON",
            "designation": "PEDIATRICS",
            "license_no": "134483"
        },
        {
            "name": "DR. MA. LOURDES SAMSON - ALANZADO",
            "designation": "DENTIST III",
            "license_no": "26564"
        },
        {
            "name": "DR. MARIGOLD B. ALBURO - KATADA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140046"
        },
        {
            "name": "DR. JEREMY ANNE A. ALCAZAR-CABRERA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "124448"
        },
        {
            "name": "DR. MIX L. ALEGADO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152348"
        },
        {
            "name": "DR. MIX L. ALEGADO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152348"
        },
        {
            "name": "DR. AMYTESS T. ALINSUGAY",
            "designation": "MEDICAL OFFICER III",
            "license_no": "142236"
        },
        {
            "name": "DR. YAHYA-MAR M. ALIP",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "131420"
        },
        {
            "name": "DR. JADY JEAN T. ALJAS",
            "designation": "MEDICAL OFFICER III",
            "license_no": "150568"
        },
        {
            "name": "DR. ELMA MAE L. ALONSO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152202"
        },
        {
            "name": "DR. KEZIAH VINEY O. ALVAREZ",
            "designation": "MEDICAL SPECIALIST II",
            "license_no": "121456"
        },
        {
            "name": "DR. JO AYNSLEY P. AMON",
            "designation": "MEDICAL OFFICER III",
            "license_no": "139642"
        },
        {
            "name": "DR. ALSALMAN A. ANAM",
            "designation": "MEDICAL OFFICER III",
            "license_no": "146388"
        },
        {
            "name": "DR. MARK M. ANDO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "129276"
        },
        {
            "name": "DR. GULAMU KHAIBAR B. ANGSA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "107517"
        },
        {
            "name": "DR. MAY ANN M. ALOTA-ANIN",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "115402"
        },
        {
            "name": "DR. CHERIE-LEE A. APIAG",
            "designation": "REHABILITATION MEDICINE",
            "license_no": "128906"
        },
        {
            "name": "DR. ALFER J. ARELLANO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "144960"
        },
        {
            "name": "DR. KEVIN COLT M. ASOQUE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "136909"
        },
        {
            "name": "DR. ALBERT CHRISTOPHER C. AVILES",
            "designation": "MEDICAL OFFICER III",
            "license_no": "141679"
        },
        {
            "name": "DR. CHRISTOPHER D. AWIL",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "106327"
        },
        {
            "name": "DR. RAFAEL A. BACALLA III",
            "designation": "MEDICAL OFFICER III",
            "license_no": "147136"
        },
        {
            "name": "DR. LUI MIGUEL J. BALBUENA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152635"
        },
        {
            "name": "DR. RYLENE A. BAQUILOD",
            "designation": "PULMONOLOGIST",
            "license_no": "118483"
        },
        {
            "name": "DR. PENNY JOY H. BARBADILLO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "141604"
        },
        {
            "name": "DR. CARMELO L. BARCENAS",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "73404"
        },
        {
            "name": "DR. PUTRI HADJALIAH T. BASER",
            "designation": "MEDICAL OFFICER III",
            "license_no": "130735"
        },
        {
            "name": "DR. FLORENTINO M. BERDIN JR.",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "86978"
        },
        {
            "name": "DR. MELISSA FLEUR T. BERNADO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "150582"
        },
        {
            "name": "DR. JAMES C. BERNAL",
            "designation": "MEDICAL OFFICER III",
            "license_no": "142129"
        },
        {
            "name": "DR. GRACIA NIÑA R. BONGABONG",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "123823"
        },
        {
            "name": "DR. FLORENCE MAE D. BONGO",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "146278"
        },
        {
            "name": "DR. ALVIN CHRISTIAN C. BORBON",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "124960"
        },
        {
            "name": "DR. JOSE CHRISTOPHER R. CABAHUG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "127354"
        },
        {
            "name": "DR. MONA JANE S. CABANIG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "153036"
        },
        {
            "name": "DR. RICK MAN C. CABELLO",
            "designation": "DENTIST II",
            "license_no": "53307"
        },
        {
            "name": "DR. STEPHANIE MAE R. CABILAO-MAALA",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "126949"
        },
        {
            "name": "DR. ARNEIL KIM O. CABRERA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "147750"
        },
        {
            "name": "DR. CARLA B. CABRERA",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "115572"
        },
        {
            "name": "DR. FAITH H. CAGULADA",
            "designation": "MEDICAL SPECIALIST III",
            "license_no": "110223"
        },
        {
            "name": "DR. CYRIELLE CAMBRONERO",
            "designation": "OBSTETRICS AND GYNECOLOGY",
            "license_no": "129899"
        },
        {
            "name": "DR. JORELLE MYKA B. CAMPANO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "128439"
        },
        {
            "name": "DR. CYD D. CAÑAS",
            "designation": "MEDICAL OFFICER III",
            "license_no": "121693"
        },
        {
            "name": "DR. FAITH T. CANTOY",
            "designation": "OBSTETRICS AND GYNECOLOGY",
            "license_no": "129840"
        },
        {
            "name": "DR. CRISTINA R. CASTAÑEDA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "121523"
        },
        {
            "name": "DR. ALEXZA C. CEBALLOS",
            "designation": "MEDICAL OFFICER III",
            "license_no": "155543"
        },
        {
            "name": "DR. JANELLE WINELYN Y. CHANG",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "137003"
        },
        {
            "name": "DR. DON JOSEF P. CHIONG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "150539"
        },
        {
            "name": "DR. JEZAH MYRA E. CO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "146772"
        },
        {
            "name": "DR. BARBARRA JANE B. CO",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "121519"
        },
        {
            "name": "DR. MA. CAMILA T. CONDE",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "49001"
        },
        {
            "name": "DR. HONEY DONESA-CORDOVEZ",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "114177"
        },
        {
            "name": "DR. JEROME G. CORETICO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "114447"
        },
        {
            "name": "DR. JULI DENISE V. CUARTO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "130011"
        },
        {
            "name": "MARY FEL ANGELI P. DABALOS",
            "designation": "PHYSICIAN",
            "license_no": "143655"
        },
        {
            "name": "DR. MARY JOY M. MALONES-DACULIAT",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "113093"
        },
        {
            "name": "DR. KAREN BEA E. DALENA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "139377"
        },
        {
            "name": "DR. JO JANETTE R. DE LA CALZADA",
            "designation": "GENERAL PEDIATRICS-PEDIATRIC NEUROLOGY",
            "license_no": "83839"
        },
        {
            "name": "DR. WILSON C. DE LA CALZADA",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "86690"
        },
        {
            "name": "DR. MA. GLADYS T. SACNANAS - DECENA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "126364"
        },
        {
            "name": "DR. DELORE GAY L. DEL MAR",
            "designation": "MEDICAL OFFICER III",
            "license_no": "150592"
        },
        {
            "name": "DR. GLADYS A. BARRETA - DELA PAZ",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "117863"
        },
        {
            "name": "DR. EDEN M. DEMEGILLO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "101410"
        },
        {
            "name": "DR. KHIN LEOGIN D. DIAZ",
            "designation": "MEDICAL OFFICER III",
            "license_no": "154489"
        },
        {
            "name": "DR. MARIA PAULINA A. DIMPAS",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "82200"
        },
        {
            "name": "DR. MA. PATRICIA ANDREA S. DIVINAGRACIA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "160734"
        },
        {
            "name": "DR. FELI ROSE D. DOMUGHO-PARACUELLES",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "125164"
        },
        {
            "name": "DR. MANUEL EMERSON S. DONALDO",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "59549"
        },
        {
            "name": "DR. KEVIN CLIFFORD B. DUEÑAS",
            "designation": "ADULT GASTROENTEROLOGY",
            "license_no": "127641"
        },
        {
            "name": "DR. CELESTE JOY B. DUMAGAN",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "126974"
        },
        {
            "name": "DR. KENNY M. DURANGPARANG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152059"
        },
        {
            "name": "DR. SIEGFRIED P. DY",
            "designation": "MEDICAL OFFICER III",
            "license_no": "141021"
        },
        {
            "name": "DR. DESIREE U. DY-HOLAYSAN",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "101423"
        },
        {
            "name": "DR. MA. ELOIZA C. EIJANSANTOS",
            "designation": "MEDICAL OFFICER III",
            "license_no": "137685"
        },
        {
            "name": "DR. EFREN M. EMPANADO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "153316"
        },
        {
            "name": "DR. LIAIA B. ENOLPE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "159692"
        },
        {
            "name": "DR. WYNCHELLE MAY A. ENRIQUEZ",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "127685"
        },
        {
            "name": "DR. WYNCHRISTER ENRIQUEZ",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "130186"
        },
        {
            "name": "DR. SADAMITSU ERAMIS",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140432"
        },
        {
            "name": "DR. JONIS MICHAEL L. ESGUERRA",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "127705"
        },
        {
            "name": "DR. TRILBE RONILYN F. ESPINA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "131554"
        },
        {
            "name": "DR. SHARMILA A. ESPINA",
            "designation": "MEDICAL SPECIALIST III",
            "license_no": "111916"
        },
        {
            "name": "DR. MARIA FATIMA B. ESTRAÑERO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "136805"
        },
        {
            "name": "DR. MAYBELLINE R. ESTROSO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "124308"
        },
        {
            "name": "DR. KEZIAH WYN G. FALCON",
            "designation": "MEDICAL OFFICER III",
            "license_no": "154890"
        },
        {
            "name": "DR. SALVE MARIE O. FERNANDEZ",
            "designation": "MEDICAL OFFICER III",
            "license_no": "144851"
        },
        {
            "name": "DR. REY EVAN A. FLORES",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140886"
        },
        {
            "name": "DR. ANDRIE JEREMY FORMANEZ",
            "designation": "OTORHINOLARYNGOLOGIST HEAD & NECK SURGEON",
            "license_no": "119286"
        },
        {
            "name": "DR. NORMAN L. FORMILLEZA JR.",
            "designation": "MEDICAL OFFICER III",
            "license_no": "154110"
        },
        {
            "name": "DR. JOSE V. FORROSUELO JR.",
            "designation": "MEDICAL OFFICER III",
            "license_no": "147245"
        },
        {
            "name": "DR. JOHN RAY D. GAGATAM",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140559"
        },
        {
            "name": "DR. JESSAH GAY C. GALANG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "147742"
        },
        {
            "name": "DR. LOU ANGELIE M. GALLARES",
            "designation": "MEDICAL OFFICER III",
            "license_no": "154111"
        },
        {
            "name": "DR. DAISY MARIE B. MENDOZA-GARBO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "120136"
        },
        {
            "name": "DR. BYRON S. GARCIA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "122873"
        },
        {
            "name": "DR. JACQUELENE C. GAVIOLA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "145394"
        },
        {
            "name": "DR. ANGELIQUE LOVE C. TIGLAO-GICA",
            "designation": "ENDOCRINOLOGY",
            "license_no": "128443"
        },
        {
            "name": "DR. PHILIP HESTER M. GILBUEANA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "121536"
        },
        {
            "name": "DR. LYZANNE MARYL T. GO",
            "designation": "IM - ENDOCRINOLOGY",
            "license_no": "123742"
        },
        {
            "name": "DR. JUANITO JUNEY C. GO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "148145"
        },
        {
            "name": "DR. FERLINE RACHELLE Y. GO",
            "designation": "MEDICAL OFFICER",
            "license_no": "131213"
        },
        {
            "name": "DR. JIMELYN ROSS Y. GO",
            "designation": "MEDICAL SPECIALIST III",
            "license_no": "121698"
        },
        {
            "name": "DR. APRIL JOYCE H. GOC-ONG",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "0147095"
        },
        {
            "name": "DR. AMETHYST MAE L. GONZAGA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "106373"
        },
        {
            "name": "DR. MAILYN C. GONZALEZ",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "115403"
        },
        {
            "name": "DR. ARRISHA A. HOLGANZA-AVILA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "124234"
        },
        {
            "name": "DR. SHIRLEY WYLENE R. HULSEY",
            "designation": "MEDICAL OFFICER III",
            "license_no": "161364"
        },
        {
            "name": "DR. CHERYL G. DAVID-IBAY",
            "designation": "MEDICAL SPECIALIST III",
            "license_no": "111805"
        },
        {
            "name": "DR. ATHENA MAE L. IBON",
            "designation": "MEDICAL OFFICER III",
            "license_no": "154344"
        },
        {
            "name": "DR. PAULO C. IDRIS",
            "designation": "MEDICAL OFFICER III",
            "license_no": "149365"
        },
        {
            "name": "DR. MARY ELLAINE D. INOCIAN",
            "designation": "MEDICAL OFFICER III",
            "license_no": "130746"
        },
        {
            "name": "DR. CHRISTIE ANNE V. INSO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "117154"
        },
        {
            "name": "DR. KERWIN A. INSO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "129344"
        },
        {
            "name": "DR. MITZI ROSE C. INTING",
            "designation": "IM - INFECTIOUS DISEASES",
            "license_no": "119329"
        },
        {
            "name": "DR. MAY MARY S. INTONG-NAPIGKIT",
            "designation": "MEDICAL OFFICER III",
            "license_no": "144911"
        },
        {
            "name": "DR. MARIENELLA C. JARINA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "123700"
        },
        {
            "name": "DR. LOUISE BERNADETTE B. JAVIER",
            "designation": "MEDICAL OFFICER III",
            "license_no": "151853"
        },
        {
            "name": "DR. GRACE D. JUNTILLA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "117845"
        },
        {
            "name": "DR. FERDINAND P. KIONISALA",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "74746"
        },
        {
            "name": "DR. APRIL CANDY U. KONG",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "123716"
        },
        {
            "name": "DR. GERMAINE MARIZ B. LABADAN",
            "designation": "MEDICAL OFFICER III",
            "license_no": "141755"
        },
        {
            "name": "DR. STACY V. LAPE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "135796"
        },
        {
            "name": "DR. ANNABEL M. LARANJO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "103489"
        },
        {
            "name": "DR. ETHEL ANNE T. LARIEGO",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "115405"
        },
        {
            "name": "DR. TYRONNE V. LARIEGO",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "119297"
        },
        {
            "name": "DR. KAZELINE L. LASDOCE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140729"
        },
        {
            "name": "DR. BERLIN B. BARCENILLA-LASTIMOSA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "122215"
        },
        {
            "name": "DR. MARIA LOURDES M. LAYA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152275"
        },
        {
            "name": "DR. JONATHAN IRVIN P. LEGASPI",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "123786"
        },
        {
            "name": "DR. WALTER IAN A. LIM",
            "designation": "MEDICAL OFFICER III",
            "license_no": "135346"
        },
        {
            "name": "DR. KARINA ANGELA G. LIPARDO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152247"
        },
        {
            "name": "DR. ANN E. LOYGOS",
            "designation": "MEDICAL OFFICER III",
            "license_no": "146274"
        },
        {
            "name": "DR. MARISSA B. LOZADA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "99296"
        },
        {
            "name": "DR. HANS MATTHEW Y. LUA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "136797"
        },
        {
            "name": "DR. GLADDES D. LUMANSOC",
            "designation": "MEDICAL OFFICER III",
            "license_no": "150580"
        },
        {
            "name": "DR. SHEILA MAE T. MAGALLANES",
            "designation": "MEDICAL OFFICER III",
            "license_no": "150562"
        },
        {
            "name": "DR. DIADEM JANE C. MAGLANGIT",
            "designation": "MEDICAL OFFICER III",
            "license_no": "132345"
        },
        {
            "name": "DR. MICHELE ANN C. MAHILUM",
            "designation": "MEDICAL OFFICER III",
            "license_no": "145089"
        },
        {
            "name": "DR. STEPHEN PAUL C. MAHILUM",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152911"
        },
        {
            "name": "DR. MARJORIE Y. MAHINAY",
            "designation": "MEDICAL OFFICER III",
            "license_no": "149005"
        },
        {
            "name": "DR. PORTIA T. MAHINAY",
            "designation": "MEDICAL OFFICER III",
            "license_no": "149005"
        },
        {
            "name": "DR. ERWIN FRANCIS S. MANAGAYTAY",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140495"
        },
        {
            "name": "DR. KRISTINE LISSETTE Y. MANAOG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "141654"
        },
        {
            "name": "DR. GREGORIO JESUS CONSTANTINO E. MANGUERRA",
            "designation": "MEDICAL SPECIALIST II",
            "license_no": "117860"
        },
        {
            "name": "DR. EARL JUSTINE E. MARTE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "139949"
        },
        {
            "name": "DR. RYAN W. MASCARIÑAS",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "125133"
        },
        {
            "name": "DR. SIMON PETER P. MOLLANEDA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140060"
        },
        {
            "name": "DR. MELLO DEE P. MONTE",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "124212"
        },
        {
            "name": "DR. BOVETTE KRISTINE MAE R. INDOLOS-MONTECILLO",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "131206"
        },
        {
            "name": "DR. ANGELI P. MONTEMOR",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "110044"
        },
        {
            "name": "DR. JESSAH APRIL S. NAINGUE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "150559"
        },
        {
            "name": "DR. MARIA CHRISTINA CONCEPCION URSAL-NAPULI",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "111774"
        },
        {
            "name": "DR. STEPHEN L. NASIAD",
            "designation": "MEDICAL OFFICER III",
            "license_no": "139814"
        },
        {
            "name": "DR. LLOYD IVAN N. NAVAL",
            "designation": "MEDICAL OFFICER III",
            "license_no": "129548"
        },
        {
            "name": "DR. JEROME PATRICK C. NAZARETH",
            "designation": "MEDICAL OFFICER III",
            "license_no": "150615"
        },
        {
            "name": "DR. FRANNIE JANE G. NILLAMA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "145128"
        },
        {
            "name": "DR. JASMIN O. OLORVIDA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "95018"
        },
        {
            "name": "DR. RUSTICO T. OMETER JR.",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152145"
        },
        {
            "name": "DR. LYNART KEVIN R. OMNES",
            "designation": "MEDICAL OFFICER III",
            "license_no": "144891"
        },
        {
            "name": "DR. ELLA REYES - OMOLON",
            "designation": "MEDICAL SPECIALIST III",
            "license_no": "110095"
        },
        {
            "name": "DR. MARK NEIL D. OMOLON",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "104457"
        },
        {
            "name": "DR. LUKE REY A. OUANO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "133886"
        },
        {
            "name": "DR. DAVE MICHAEL H. OYAS",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "134491"
        },
        {
            "name": "DR. JOSUEL MITCH M. PAETE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "144121"
        },
        {
            "name": "DR. MARY HAYETH C. PAILDEN",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "114280"
        },
        {
            "name": "DR. MARY THERESE C. PARADIANG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "131486"
        },
        {
            "name": "DR. LISETTE FRANCINE T. PARILLA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "144944"
        },
        {
            "name": "DR. KRIS DANIEL V. PARILLA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "119269"
        },
        {
            "name": "DR. LOVELY REIZEL M. PAROHINOG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "138784"
        },
        {
            "name": "DR. KAREN A. PAYAD",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "130033"
        },
        {
            "name": "DR. MADELLEINE P. PEROCHO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "123717"
        },
        {
            "name": "DR. RALPH JACINTO P. PINAT",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "109911"
        },
        {
            "name": "DR. GLENN L. PUNAY",
            "designation": "MEDICAL OFFICER III",
            "license_no": "132175"
        },
        {
            "name": "DR. IVAN JAMES T. QUIAL",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "128342"
        },
        {
            "name": "DR. ISAGANI ERIS D. QUILIOPE",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "112932"
        },
        {
            "name": "DR. KYZLE SYRRA G. RAMOS",
            "designation": "OBSTETRICS AND GYNECOLOGY",
            "license_no": "136730"
        },
        {
            "name": "DR. GUADA GISELLE S. RARANG",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "123741"
        },
        {
            "name": "DR. NERI A. RATCLIFFE",
            "designation": "MEDICAL SPECIALIST II",
            "license_no": "121516"
        },
        {
            "name": "DR. MILAN M. RATUNIL",
            "designation": "MEDICAL SPECIALIST II",
            "license_no": "108879"
        },
        {
            "name": "DR. DUVALJOHN U. RAZA",
            "designation": "MEDICAL SPECIALIST IV",
            "license_no": "107418"
        },
        {
            "name": "DR. RUTHEL JUN G. REJUSO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "159116"
        },
        {
            "name": "DR. ERNESTO JACA REPOLLO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "122241"
        },
        {
            "name": "DR. MARK BENNETT M. REROMA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "152171"
        },
        {
            "name": "DR. JERALDINE D. REVILLES",
            "designation": "IM NEPHROLOGY",
            "license_no": "128661"
        },
        {
            "name": "DR. JANICE C. ROBLE",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "117009"
        },
        {
            "name": "DR. VINCENT MATTHEW L. ROBLE II",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "111931"
        },
        {
            "name": "DR. FLORIEBELLE FAITH C. RODRIGUEZ",
            "designation": "MEDICAL OFFICER III",
            "license_no": "148705"
        },
        {
            "name": "DR. MARIA ELIN MAY B. ROMA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "142371"
        },
        {
            "name": "DR. CANDY ROSS A. ROMERO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "127257"
        },
        {
            "name": "DR. SHIRLYN G. ROMO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "143150"
        },
        {
            "name": "DR. NIÑO C. RUDAS",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140050"
        },
        {
            "name": "DR. KEITH MOON Q. SABERON",
            "designation": "NEUROLOGY",
            "license_no": "127707"
        },
        {
            "name": "DR. ANGELI B. SALUT",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "137385"
        },
        {
            "name": "DR. WAILEA FAYE C. SALVA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "161335"
        },
        {
            "name": "DR. MARYAN C. SAMSON",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "130710"
        },
        {
            "name": "DR. JERIMAE S. SAMSON",
            "designation": "MEDICAL OFFICER III",
            "license_no": "140026"
        },
        {
            "name": "DR. CLAIRE T. SANAANI",
            "designation": "MEDICAL OFFICER III",
            "license_no": "124138"
        },
        {
            "name": "DR. SHEILA S. SANTILLAN",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "109038"
        },
        {
            "name": "DR. EARL DJ P. SARABOSING",
            "designation": "OPHTHALMOLOGY",
            "license_no": "132467"
        },
        {
            "name": "DR. GERARD M. SARANZA",
            "designation": "NEUROLOGY-MOVEMENT DISORDERS",
            "license_no": "123600"
        },
        {
            "name": "DR. CASHMERE MALAINE C. SAYRUDDIN",
            "designation": "MEDICAL OFFICER III",
            "license_no": "119402"
        },
        {
            "name": "DR. WINIHILMA C. SEDENTARIO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "126476"
        },
        {
            "name": "DR. KAREN LOUISE BETHANY V. SILADAN",
            "designation": "MEDICAL OFFICER III",
            "license_no": "136427"
        },
        {
            "name": "DR. ANTHONY CARLO C. SILVA",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "132947"
        },
        {
            "name": "DR. FLORALIE ANN M. SOLANTE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "143169"
        },
        {
            "name": "DR. KATHRYN ANN P. SUGAROL",
            "designation": "MEDICAL OFFICER III",
            "license_no": "154750"
        },
        {
            "name": "DR. MARY MARIZ O. SUSAYA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "161362"
        },
        {
            "name": "DR. MANFRED T. TABILOG",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "128693"
        },
        {
            "name": "DR. VILLAFLOR AVE PHEREIN V. TABIQUE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "142478"
        },
        {
            "name": "DR. MARY ROSE D. TALADRO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "128921"
        },
        {
            "name": "DR. EDD SHERWYN LUKE Q. TAN",
            "designation": "INTERNAL MEDICINE",
            "license_no": "133321"
        },
        {
            "name": "DR. JENNIFER JOYCE GOCHAN-TAN",
            "designation": "MEDICAL OFFICER III",
            "license_no": "127372"
        },
        {
            "name": "DR. MARIE ANDONE L. TAN",
            "designation": "OBSTETRICS AND GYNECOLOGY",
            "license_no": "130020"
        },
        {
            "name": "DR. PATRICIA JANE L. TAN",
            "designation": "OBSTETRICS AND GYNECOLOGY",
            "license_no": "124229"
        },
        {
            "name": "DR. THOMAS VINCENT A. TAN",
            "designation": "MEDICAL OFFICER III",
            "license_no": "131742"
        },
        {
            "name": "DR. KAREN KRISTY QUIÑANOLA TORREMOCHA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "115394"
        },
        {
            "name": "DR. CECILLE CAMILLE N. INIT-UBOD",
            "designation": "MEDICAL OFFICER III",
            "license_no": "145247"
        },
        {
            "name": "DR. REYNOLD JOHN D. VALENCIA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "146800"
        },
        {
            "name": "DR. ELOISA MARIANNE C. VALIENTE",
            "designation": "MEDICAL OFFICER III",
            "license_no": "145501"
        },
        {
            "name": "DR. TZAR FRANCIS E. VERAME",
            "designation": "MEDICAL OFFICER III",
            "license_no": "128346"
        },
        {
            "name": "DR. DOMINIC VICUÑA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "117160"
        },
        {
            "name": "DR. GABRIEL ANTHONY V. VILLA",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "114333"
        },
        {
            "name": "DR. PAOLO LUIGI C. VILLAMIL",
            "designation": "ATTENDING PHYSICIAN",
            "license_no": "152310"
        },
        {
            "name": "DR. REGIL KENT L. VILLAMOR",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "114732"
        },
        {
            "name": "DR. STEPHANIE R. VILLAR",
            "designation": "MEDICAL OFFICER III",
            "license_no": "156002"
        },
        {
            "name": "DR. PAUL R. VILLEGAS",
            "designation": "MEDICAL SPECIALIST II",
            "license_no": "100353"
        },
        {
            "name": "DR. ROSS C. VILLERO",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "107232"
        },
        {
            "name": "DR. TWEETY P. VISITACION",
            "designation": "MEDICAL OFFICER III",
            "license_no": "130025"
        },
        {
            "name": "DR. JASON P. WONG",
            "designation": "MEDICAL OFFICER III",
            "license_no": "145736"
        },
        {
            "name": "DR. JAN MICHAEL V. YAP",
            "designation": "MEDICAL OFFICER IV",
            "license_no": "124599"
        },
        {
            "name": "DR. KATRINA YRICA C. YSO",
            "designation": "MEDICAL OFFICER III",
            "license_no": "142506"
        },
        {
            "name": "DR. JAMIE GLOR R. YU",
            "designation": "MEDICAL OFFICER III",
            "license_no": "156251"
        },
        {
            "name": "DR. DONNY JAY E. YU",
            "designation": "MEDICAL SPECIALIST III",
            "license_no": "106197"
        },
        {
            "name": "DR. ANA ISOBELLE K. ZERNA",
            "designation": "MEDICAL OFFICER III",
            "license_no": "145756"
        }
    ]

    let type = "";

    $(document).ready(() => {
        $("#select_doctor").select2({
            dropdownParent: $("#doctor_modal"),
            width: '100%'
        });

        $("#diagnosis").on("keypress", function (e) {
            // Check if the pressed key is Enter (key code 13)
            if (e.which == 13) {
                // Prevent the default behavior of Enter key (which creates a new line)
                // Append a <br> tag to the textarea's value
                $("#diagnosis").val($(this).val() + '<br>');
            }
        });

        $('#filter_patient').on('keyup', function (e) {
            if (e.key === 'Enter') {
                getCertificates();
            } else if ($(this).val() === '') {
                getCertificates();
            }
        });

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $("body").on("change", "#purpose", function () {
            $("#purpose_container").addClass("d-none");
            $("#second_purpose").val("");
            if ($(this).val() == "Financial and Medical Assistance Program available in the hospital") {
                $("#purpose_container").removeClass("d-none");
            }
        });

        $("#btn_add_report").click(function () {
            $("#report_modal").modal("show");
        });

        $("#btn_download_report").click(function () {
            const filtered_date = $("#filter_date").val();

            if (filtered_date == "") {
                alert("Please specify date range");
                return;
            }


            let from_date = moment(filtered_date.split("-")[0].trim(), "MM/DD/YYYY");
            let to_date = moment(filtered_date.split("-")[1].trim(), "MM/DD/YYYY");


            let to_month_name = "";
            if (from_date.format("M") !== to_date.format("M")) {
                to_month_name = to_date.format("MMMM");
            }

            let title = "SUMMARY REPORT FOR THE MONTH OF " + from_date.format("MMMM") + " " + from_date.format("D");
            if (to_month_name === "") {
                if (from_date.format("D") === to_date.format("D"))
                    title += to_date.format(", YYYY");
                else {
                    title += to_date.format("-D, YYYY");
                }
            } else
                title += " - " + to_month_name + " " + to_date.format("D, YYYY");

            window.open("/qrcode-tracker/generate_report?from_date=" + from_date.format("YYYY-MM-DD") + "&to_date=" + to_date.format("YYYY-MM-DD") + "&title=" + title, "_blank");
        });

        $("#btn_generate_report").click(async function () {
            const filtered_date = $("#filter_date").val();

            if (filtered_date == "") {
                alert("Please specify date range");
                return;
            }


            let from_date = moment(filtered_date.split("-")[0].trim(), "MM/DD/YYYY");
            let to_date = moment(filtered_date.split("-")[1].trim(), "MM/DD/YYYY");

            const response = await fetch('{{ route('generateTableReport') }}?from_date=' + from_date.format("YYYY-MM-DD") + "&to_date=" + to_date.format("YYYY-MM-DD"));
            const data = await response.json();

            $("#report_list").empty();
            data.forEach(it => {
                const date_requested = (it.date_requested) ? moment(it.date_requested).format("MM/DD/YYYY hh:mm A") : "";
                const date_finished = (it.date_finished) ? moment(it.date_finished).format("MM/DD/YYYY hh:mm A") : "";
                const tr = `
                <tr>
                    <td>` + it.patient + `</td>
                    <td>` + it.type + `</td>
                    <td>` + it.charge_slip_no + `</td>
                    <td>` + it.or_no + `</td>
                    <td>` + it.requesting_person + `</td>
                    <td>` + it.relationship + `</td>
                    <td>` + date_requested + `</td>
                    <td>` + it.registry_no + `</td>
                    <td>` + date_finished + `</td>
                </tr>`;
                $("#report_list").append(tr);
            });
        });

        $("#btn_search").click(function () {
            page = 0;
            getCertificates();
        });

        $("#btn_next").click(function () {
            page++;
            getCertificates();
            $("#btn_prev").removeClass("d-none");
        });

        $("#btn_prev").click(function () {
            if (page == 0) return;
            if (page == 1) {
                $("#btn_prev").addClass("d-none");
            }
            page--;
            getCertificates();
        });

        $("#btn_add_ordinary").click(() => {
            certificate_id = 0;
            type = "ordinary";
            $("#certificate_modal").modal('show');
            showSpinner();
            fetch('/qrcode-tracker/partial-form?type=' + type, {
                method: "GET"
            })
                .then(response => response.text()) // Convert response to text
                .then(html => {
                    $("#certificate_modal #certificate_form").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");

                    //APPEND DOCTORS ON A SELECT
                })
                .catch(error => console.error(error));
        });

        $("#btn_add_maipp").click(() => {
            certificate_id = 0;
            type = "maipp";
            $("#certificate_modal").modal('show');
            showSpinner();
            fetch('/qrcode-tracker/partial-form?type=' + type, {
                method: "GET"
            })
                .then(response => response.text()) // Convert response to text
                .then(html => {
                    $("#certificate_modal #certificate_form").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
                })
                .catch(error => console.error(error));
        });

        $("#btn_add_medico_legal").click(() => {
            certificate_id = 0;
            type = "medico_legal";
            $("#certificate_modal").modal('show');
            showSpinner();
            fetch('/qrcode-tracker/partial-form?type=' + type, {
                method: "GET"
            })
                .then(response => response.text()) // Convert response to text
                .then(html => {
                    $("#certificate_modal #certificate_form").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
                })
                .catch(error => console.error(error));
        });

        $("#btn_add_diagnosis").click(function () {
            diagnosis_index = -1;
            $("#diagnosis").val("");
            $("#diagnosis_modal").modal("show");
        });

        $("#btn_add_doctor").click(function () {
            $("#doctor_modal").modal("show");
        });

        $("#btn_set_doctor").click(function () {
            const selected_doctor = $("#select_doctor").val();
            if (!selected_doctor) {
                alert("Please specify doctor");
                return;
            }

            const doctor = getDoctorByLicense(selected_doctor);
            if (!doctor) {
                alert("Doctor license no. dont't exists");
                return;
            }

            //SET FORM DOCTOR
            $("#doctor").val(doctor.name);
            $("#doctor_designation").val(doctor.designation);
            $("#doctor_license").val(doctor.license_no);

            $("#doctor_modal").modal("hide");
        });


        $("#btn_save_diagnosis").click(function () {
            let diagnosis = $("#diagnosis").val();
            diagnosis = diagnosis.replace(/\n/g, "");

            if (diagnosis == '') {
                alert("Please fill in diagnosis");
                return;
            }

            if (diagnosis_index > -1) {
                $("#diagnosis_list tr:eq(" + diagnosis_index + ") td:eq(0)").html(diagnosis);
                $("#diagnosis_modal").modal("hide");
                diagnosis_index = -1;
            } else {
                let tr = "<tr>";
                tr += "<td style='width: 90%'>" + diagnosis + "</td>"
                tr += "<td style='width: 5%'><button type='button' class='btn btn-sm btn-transparent' onClick='editDiagnosis(this)'><i class='bi bi-pencil-fill text-success'></i></button></td>"
                tr += "<td style='width: 5%'><button type='button' class='btn btn-sm btn-transparent' onClick='deleteDiagnosis(this)'><i class='bi bi-trash-fill text-danger'></i></button></td>"
                tr += "</tr>";
                $("#diagnosis_list").append(tr);
            }
            $("#diagnosis").val("");
        });

        $("#btn_save").click(async function () {
            const certificate_no = $("#certificate_no").val().trim();
            const health_record_no = $("#health_record_no").val().trim();
            const date_issued = $("#date_issued").val().trim();
            const patient = $("#patient").val().trim();
            const age = $("#age").val().trim();
            const sex = $("#sex").val();
            const civil_status = $("#civil_status").val();
            const address = $("#address").val().trim();
            const date_examined = $("#date_examined").val().trim();
            const days_barred = $("#days_barred").val();
            const doctor = $("#doctor").val().trim();
            const doctor_designation = $("#doctor_designation").val();
            const doctor_license = $("#doctor_license").val().trim();
            const requesting_person = $("#requesting_person").val();
            const relationship = $("#relationship").val();
            const purpose = $("#purpose").val();
            const second_purpose = $("#second_purpose").val();
            const or_no = $("#or_no").val().trim();
            const amount = $("#amount").val().trim();
            const charge_slip_no = $("#charge_slip_no").val();
            const registry_no = $("#registry_no").val();
            const date_requested = $("#date_requested").val().trim();
            const date_finished = $("#date_finished").val().trim();
            const diagnosis_array = [];

            for (let i = 0; i < $("#diagnosis_list tr").length; i++) {
                const diagnosis = $("#diagnosis_list tr:eq(" + i + ") td:eq(0)").html().trim();
                diagnosis_array.push({
                    diagnosis: diagnosis
                });
            }

            const noi = $("#noi").val();
            const doi = $("#doi").val();
            const poi = $("#poi").val();
            const toi = $("#toi").val();

            const sustained = {
                "noi": (noi === undefined) ? null : noi,
                "doi": (doi === undefined) ? null : doi,
                "poi": (poi === undefined) ? null : poi,
                "toi": (toi === undefined) ? null : toi
            }

            const params = {
                "id": certificate_id,
                "certificate_no": certificate_no,
                "health_record_no": health_record_no,
                "date_issued": date_issued,
                "patient": patient,
                "age": age,
                "sex": (sex === undefined) ? null : sex,
                "civil_status": (civil_status === undefined) ? null : civil_status,
                "address": address,
                "date_examined": date_examined,
                "days_barred": (days_barred === undefined) ? null : days_barred,
                "doctor": doctor,
                "doctor_designation": (doctor_designation === undefined) ? null : doctor_designation,
                "doctor_license": doctor_license,
                "requesting_person": (requesting_person === undefined) ? null : requesting_person,
                "relationship": relationship,
                "charge_slip_no": charge_slip_no,
                "registry_no": registry_no,
                "date_requested": date_requested,
                "date_finished": date_finished,
                "purpose": (purpose === undefined) ? null : purpose,
                "second_purpose": (second_purpose === undefined) ? null : second_purpose,
                "or_no": or_no,
                "amount": amount,
                "charge_slip_no": charge_slip_no,
                "registry_no": registry_no,
                "date_requested": date_requested,
                "date_finished": date_finished,
                "type": type,
                "diagnosis": diagnosis_array,
                "sustained": (noi === undefined) ? null : sustained
            }
            let is_valid = true;
            $(".is-invalid").removeClass("is-invalid");

            if (!requesting_person) {
                toastr.error('Requesting person is required');
                $("#requesting_person").addClass("is-invalid");
                is_valid = false;
            }

            if (!relationship) {
                toastr.error('Relationship is required');
                $("#relationship").addClass("is-invalid");
                is_valid = false;
            }

            if (!charge_slip_no) {
                toastr.error('Charge slip no. is required');
                $("#charge_slip_no").addClass("is-invalid");
                is_valid = false;
            }

            if (!registry_no) {
                toastr.error('Registry no. is required');
                $("#registry_no").addClass("is-invalid");
                is_valid = false;
            }

            if (!date_requested) {
                toastr.error('Requesting person is required');
                $("#date_requested").addClass("is-invalid");
                is_valid = false;
            }

            switch (type) {
                case "ordinary":
                    if (!certificate_no) {
                        toastr.error('Certificate No. is required');
                        $("#certificate_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!health_record_no) {
                        toastr.error('Health Record No. is required');
                        $("#health_record_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_issued) {
                        toastr.error('Date issued is required');
                        $("#date_issued").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!patient) {
                        toastr.error('Patient is required');
                        $("#patient").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!age) {
                        toastr.error('Age is required');
                        $("#age").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!address) {
                        toastr.error('Address is required');
                        $("#address").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_examined) {
                        toastr.error('Date examined is required');
                        $("#date_examined").addClass("is-invalid");
                        is_valid = false;
                    }


                    if (!purpose) {
                        toastr.error('Purpose is required');
                        $("#purpose").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor) {
                        toastr.error('Doctor is required');
                        $("#doctor").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_designation) {
                        toastr.error('Doctor designation is required');
                        $("#doctor_designation").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_license) {
                        toastr.error('Doctor license no. is required');
                        $("#doctor_license").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }

                    break;
                case "maipp":
                    if (!certificate_no) {
                        toastr.error('Certificate No. is required');
                        $("#certificate_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!health_record_no) {
                        toastr.error('Health Record No. is required');
                        $("#health_record_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_issued) {
                        toastr.error('Date issued is required');
                        $("#date_issued").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!patient) {
                        toastr.error('Patient is required');
                        $("#patient").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!age) {
                        toastr.error('Age is required');
                        $("#age").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!sex) {
                        toastr.error('Sex is required');
                        $("#sex").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!address) {
                        toastr.error('Address is required');
                        $("#address").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_examined) {
                        toastr.error('Date examined is required');
                        $("#date_examined").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!purpose) {
                        toastr.error('Purpose is required');
                        $("#purpose").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (purpose === "Financial and Medical Assistance Program available in the hospital" && !second_purpose) {
                        toastr.error('Second purpose is required');
                        $("#second_purpose").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor) {
                        toastr.error('Doctor is required');
                        $("#doctor").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_license) {
                        toastr.error('Doctor license no. is required');
                        $("#doctor_license").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }
                    break;
                case "medico_legal":
                    if (!certificate_no) {
                        toastr.error('Certificate No. is required');
                        $("#certificate_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!health_record_no) {
                        toastr.error('Health Record No. is required');
                        $("#health_record_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_issued) {
                        toastr.error('Date issued is required');
                        $("#date_issued").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!patient) {
                        toastr.error('Patient is required');
                        $("#patient").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!age) {
                        toastr.error('Age is required');
                        $("#age").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!sex) {
                        toastr.error('Sex is required');
                        $("#sex").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!civil_status) {
                        toastr.error('Civil status is required');
                        $("#civil_status").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!address) {
                        toastr.error('Address is required');
                        $("#address").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_examined) {
                        toastr.error('Date examined is required');
                        $("#date_examined").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor) {
                        toastr.error('Doctor is required');
                        $("#doctor").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_designation) {
                        toastr.error('Doctor designation is required');
                        $("#doctor_designation").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_license) {
                        toastr.error('Doctor license no. is required');
                        $("#doctor_license").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!noi) {
                        toastr.error('NOI is required');
                        $("#noi").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doi) {
                        toastr.error('DOI is required');
                        $("#doi").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!poi) {
                        toastr.error('POI is required');
                        $("#poi").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!toi) {
                        toastr.error('TOI is required');
                        $("#toi").addClass("is-invalid");
                        is_valid = false;
                    }
                    break;
            }

            if (!is_valid) {
                return;
            }

            try {
                $(this).prop("disabled", true);
                const response = await fetch('{{route('storeCertificate')}}', {
                    method: "POST",
                    headers: HEADERS,
                    body: JSON.stringify(params)
                });

                const data = await response.json();
                $("#certificate_modal").modal("hide");
                toastr.success(data.message, "Information");
                getCertificates();
            } catch (err) {
                toastr.error(err, "Ooops");
            } finally {
                $(this).prop("disabled", false);
            }
        });

        getCertificates();
        appendDoctors();
    });

    async function printPreview(id) {
        window.open("https://dohcsmc.site/qrcode-tracker/print-preview?id=" + id, '_blank');
    }

    function editCertificate(id) {
        certificate_id = id;
        type = $("#certificate_id_" + id + " td:eq(0)").text().trim();
        $("#certificate_modal").modal("show");
        $("#certificate_modal .modal-footer").addClass("d-none");
        showSpinner();
        fetch('/qrcode-tracker/partial-form?type=' + type +
            '&id=' + id, {
            method: "GET"
        })
            .then(response => response.text()) // Convert response to text
            .then(html => {
                $("#certificate_modal #certificate_form").html(html);
                $("#certificate_modal .modal-footer").removeClass("d-none");
            })
            .catch(error => console.error(error));
    }

    async function tagCertificate(id) {
        if (confirm("Are you sure you want to tag this as done?")) {
            const response = await fetch('{{ route('tagCertificate') }}', {
                method: "PUT",
                headers: HEADERS,
                body: JSON.stringify({id: id})
            });

            if (!response.ok) {
                toastr.error("Something went wrong", "Ooops");
                console.log(response);
                return;
            }

            const data = await response.json();
            toastr.success(data.message, "Information");
            getCertificates();
        }
    }

    async function deleteCertificate(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            const response = await fetch('{{ route('deleteCertificate') }}', {
                method: "DELETE",
                headers: HEADERS,
                body: JSON.stringify({id: id})
            });

            if (!response.ok) {
                toastr.error("Something went wrong", "Ooops");
                console.log(response);
                return;
            }

            const data = await response.json();
            toastr.success(data.message, "Information");
            getCertificates();
        }
    }

    function editDiagnosis(button) {
        const tr = $(button).closest('tr');
        const diagnosis = tr.find('td:first').html();
        diagnosis_index = tr.index();

        $("#diagnosis_modal").modal("show");
        const textWithLineBreaks = diagnosis.replace(/<br>/g, '<br>\n');
        $("#diagnosis").val(textWithLineBreaks);
    }

    function deleteDiagnosis(button) {
        if (confirm("Are you sure you want to remove this record?")) {
            const tr = $(button).closest('tr');
            tr.remove();
        }
    }

    async function getCertificates() {
        const filter_patient = $("#filter_patient").val().trim();
        const filter_date_issued = $("#filter_date_issued").val();
        const response = await fetch('{{ route('getCertificates') }}?page=' + page +
            '&filter_patient=' + filter_patient +
            '&filter_date_issued=' + filter_date_issued);

        const data = await response.json();

        $("#pagination_container").addClass("d-none")
        $("#certificate_lists").empty();
        $("#btn_next").addClass("d-none");
        if (data.length < 1) {
            $("#certificate_lists").append("<tr><td colspan='8'>No record found</td></tr>");
            return;
        }

        $("#pagination_container").removeClass("d-none")

        let max_visible = data.length;
        if (max_visible == 11) {
            max_visible = 10;
            $("#btn_next").removeClass("d-none");
        }

        $("#page_items_count").text(((page * 10) + 1) + " - " + ((page * 10) + max_visible));
        for (let i = 0; i < max_visible; i++) {
            const it = data[i];
            let tr = `
                    <tr id="certificate_id_` + it.id + `">
                        <td>` + it.type + `</td>
                        <td>` + it.patient + `</td>
                        <td>` + it.health_record_no + `</td>
                        <td>` + it.certificate_no + `</td>
                        <td>` + it.date_issued + `</td>
                        <td>` + it.created_at + `</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="printPreview(` + it.id + `)">
                                <i class="bi bi-qr-code"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="editCertificate(` + it.id + `)">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </td>`;
            if (it.date_finished)
                tr += `
                        <td>
                            <button class="btn btn-sm btn-secondary" disabled>
                                <i class="bi bi-tag-fill"></i>
                            </button>
                        </td>`;
            else
                tr += `
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="tagCertificate(` + it.id + `)">
                                <i class="bi bi-tag-fill"></i>
                            </button>
                        </td>`;
            tr += `<td>
                            <button class="btn btn-sm btn-danger" onclick="deleteCertificate(` + it.id + `)">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>`

            $("#certificate_lists").append(tr);
        }
    }

    function appendDoctors() {
        $("#select_doctor").append("<option></option>");
        DOCTORS.forEach(it => {
            $("#select_doctor").append("<option value='" + it.license_no + "'>" + it.name + "</option>");
        });
    }

    function getDoctorByLicense(license_no) {
        for (let i = 0; i < DOCTORS.length; i++) {
            if (DOCTORS[i].license_no === license_no) {
                return DOCTORS[i];
            }
        }
        return null;
    }

    function showSpinner() {
        $("#certificate_modal #certificate_form").html(`
        <div class="d-flex justify-content-center align-items-center">
            <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
             </div>
        </div>`);
    }
</script>
