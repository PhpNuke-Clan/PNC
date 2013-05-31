<?php //vwar
/* #####################################################################################
 *
 * $Id: portuguese.inc.php,v 1.12 2004/03/14 20:22:10 mabu Exp $
 *
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the official addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 *
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2004
 * ---------------------------------------------
 *
 * #####################################################################################
 */

## ---- THIS FILE WILL BE EDITED BY A MACHINE ---- ##
## ----        DON'T CHANGE IT BY HAND        ---- ##

## ------------------------------- DEFINE COUNTRIES --------------------------------- ##
$country_array = array(
	"af" => "Afeganistão",
	"al" => "Albânia",
	"am" => "Arménia",
	"an" => "Paises Baixos Antilhas",
	"ao" => "Angola",
	"ar" => "Argentina",
	"at" => "Austria",
	"au" => "Australia",
	"aw" => "Aruba",
	"az" => "Azerbeijão",
	"ba" => "Bósnia e herzegovina",
	"bb" => "Barbados",
	"bd" => "Bangladesh",
	"be" => "Bélgica",
	"bf" => "Burkina Faso",
	"bg" => "Bulgária",
	"bh" => "Bahrain",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermuda",
	"bn" => "Brunei",
	"bo" => "Bolívia",
	"br" => "Brasil",
	"bs" => "Bahamas",
	"bt" => "Bhutan",
	"bw" => "Botswana",
	"bx" => "Benelux",
	"by" => "Belarus",
	"bz" => "Belize",
	"ca" => "Canadá",
	"cf" => "República De Africano Central",
	"cg" => "Congo",
	"ch" => "Suiça",
	"ci" => "D'Ivoire de Cote",
	"ck" => "Ilhas Cook",
	"cm" => "Camarões",
	"cn" => "China",
	"co" => "Colômbia",
	"cr" => "Costa Rica",
	"cu" => "Cuba",
	"cv" => "Cabo Verde",
	"cy" => "Chipre",
	"cz" => "Republica Checa",
	"de" => "Alemanha",
	"dk" => "Dinamarca",
	"dz" => "Argélia",
	"ec" => "Equador",
	"ee" => "Estónia",
	"eg" => "Egipto",
	"er" => "Eritrea",
	"es" => "Espanha",
	"et" => "Etiópia",
	"eu" => "Europa",
	"fi" => "Filandia",
	"fj" => "Fiji",
	"fo" => "Ilhas Faroe",
	"fr" => "França",
	"ga" => "Gabão",
	"ge" => "Geórgia",
	"gi" => "Gibraltar",
	"gl" => "Greenland",
	"gp" => "Guadalupe",
	"gr" => "Grécia",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Croacia",
	"ht" => "Haiti",
	"hu" => "Hungria",
	"id" => "Indonesia",
	"ie" => "Irelanda",
	"il" => "Israel",
	"in" => "India",
	"int" => "Internacional",
	"iq" => "Iraque",
	"ir" => "Irão",
	"is" => "Islandia",
	"it" => "Italia",
	"jm" => "Jamaica",
	"jo" => "Jordão",
	"jp" => "Japão",
	"ke" => "Quenia",
	"kg" => "Kirgizstão",
	"kh" => "Cambodja",
	"ki" => "Kiribati",
	"kp" => "Coreia do Norte",
	"kr" => "Republica da Coreia",
	"ky" => "Ilhas Caimão",
	"kz" => "Kazakistão",
	"lb" => "Libano",
	"lc" => "Santa Lucia",
	"li" => "Liechtenstein",
	"lk" => "Sri Lanka",
	"lt" => "Lituania",
	"lu" => "Luxemburgo",
	"lv" => "Latvia",
	"ly" => "Libia",
	"ma" => "Marrocos",
	"mc" => "Monaco",
	"md" => "Republica da Moldavia",
	"mg" => "Madagascar",
	"mn" => "Mongolia",
	"mo" => "Macau",
	"mp" => "Ilhas Mariana do Norte",
	"ms" => "Montserrat",
	"mt" => "Malta",
	"mx" => "Mexico",
	"my" => "Malasia",
	"mz" => "Moçambique",
	"na" => "Namibia",
	"nc" => "Nova Caledonia",
	"nf" => "Ilha Norfolk",
	"nl" => "Holanda",
	"no" => "Noruega",
	"np" => "Nepal",
	"nr" => "Nauru",
	"nz" => "Nova Zelandia",
	"om" => "Oman",
	"pa" => "Panamá",
	"pe" => "Peru",
	"pf" => "Polinezia Francesa",
	"ph" => "Filipinas",
	"pk" => "Paquistão",
	"pl" => "Polonia",
	"pm" => "St. Pierre e Miquelon",
	"pr" => "Porto Rico",
	"pt" => "Portugal",
	"py" => "Paraguai",
	"qa" => "Qatar",
	"ro" => "Roménia",
	"ru" => "Federação Russa",
	"sa" => "Arabia Saudita",
	"sb" => "Ilhas Salomão",
	"sca" => "Escandinávia",
	"sd" => "Sudão",
	"se" => "Suecia",
	"sg" => "Singapura",
	"si" => "Eslovenia",
	"sk" => "Republica Eslovaquia",
	"sl" => "Serra Leoa",
	"so" => "Somalia",
	"tc" => "Turks and Caicos Islands",
	"tg" => "Togo",
	"th" => "Tailandia",
	"tn" => "Tunisia",
	"to" => "Tonga",
	"tp" => "Timor Leste",
	"tr" => "Turquia",
	"tt" => "Trinidade e Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tanzania",
	"ua" => "Ukrania",
	"ug" => "Uganda",
	"uk" => "Reino Unido",
	"us" => "Estados Unidos da America",
	"uy" => "Uruguai",
	"va" => "Estado Vaticano",
	"ve" => "Venezuela",
	"vg" => "Ilhas Virginia (UK)",
	"vi" => "Ilhas Virginia (US)",
	"vn" => "Vietname",
	"ws" => "Samoa",
	"ye" => "Yemen",
	"yu" => "Jugoslavia",
	"za" => "Africa do Sul",
	"zw" => "Zimbabue"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Janeiro",
	"2" => "Fevereiro",
	"3" => "Março",
	"4" => "Abril",
	"5" => "Maio",
	"6" => "Junho",
	"7" => "Julho",
	"8" => "Agosto",
	"9" => "Setembro",
	"10" => "Outubro",
	"11" => "Novembro",
	"12" => "Dezembro"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"Dom",
	"Seg",
	"Ter",
	"Qua",
	"Qui",
	"Sex",
	"Sab"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "Alemão",
	"english" => "Inglês",
	"french" => "Francês",
	"danish" => "Dinamarquês",
	"dutch" => "Holandês",
	"spanish" => "Espanhol",
	"portuguese" => "Português",
	"italian" => "Italiano",
	"hungarian" => "Hungarian"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Mostra IP";
$str["NEWCOMMENT"] = "Novo Comentario";
$str["ADDCOMMENT"] = "Adiciona Comentario";
$str["EDITCOMMENT"] = "Edita Comentario";
$str["DELETECOMMENT"] = "Apaga Comentario";
$str["COMMENT"] = "Comentario";
$str["COMMENTS"] = "Comentarios";
$str["ENTERCOMMENT"] = "Inserir o Comentario";
$str["BACKTOCOMMENTS"] = "Voltar aos Comentarios";
$str["ADD"] = "Adicionar";
$str["CLOSEWINDOW"] = "Fechar Janela";
$str["CLICKONSMILIETOINSERT"] = "Click no smilie para o inserir";
$str["INSERTTHISSMILIE"] = "Inserir este Smilie";
$str["MORE"] = "mais";
$str["PLEASECHOOSE"] = "Escolha";
$str["STATISTICS"] = "Estatisticas";
$str["AVAILABLE"] = "disponivel";
$str["YES"] = "Sim";
$str["NO"] = "Não";
$str["SHORT"] = "curto";
$str["NOTAVAILABLE"] = "indisponivel";
$str["NOTAVAILABLESHORT"] = "n/a";
$str["DATE"] = "Data";
$str["DAY"] = "Dia";
$str["MONTH"] = "Mês";
$str["YEAR"] = "Ano";
$str["TIME"] = "Hora";
$str["OPPONENT"] = "Adversario";
$str["GAME"] = "Jogo";
$str["RESULT"] = "Resultado";
$str["CURRENTLY"] = "Actualmente";
$str["SHOW"] = "Mostrar";
$str["CHALLENGEUS"] = "Desafia-nos";
$str["LEGEND"] = "Legenda";
$str["NAME"]="Nome";
$str["SERVER"] = "Servidor";
$str["FULL"] = "cheio";
$str["CONTACT"] = "Contacto";
$str["PLAYERS"] = "Jogadores";
$str["PLAYERPERTEAM"] = "Jogadores por Equipa";
$str["LOCATIONS"] = "Mapas";
$str["LOCATION"] = "Mapa";
$str["OWNSCORES"] = "Nossos Scores";
$str["OPPSCORES"] = "Scores do Adversario";
$str["AVERAGE"] = "Média";
$str["ADDITIONALINFO"] = "Info Adicional";
$str["SIGNEDMEMBERS"] = "Membros Inscritos";
$str["MOREREQUIRED"] = "necessarios";
$str["OPTIONS"] = "Opções";
$str["SIGNUP"] = "Inscrever";
$str["SIGNOFF"] = "Desinscrever";
$str["CALENDAR"] = "Calendario";
$str["JUMPTOCURRENTMONTH"] = "Ir para o Mês corrente";
$str["ON"] = "On";
$str["OFF"] = "Off";
$str["HTMLIS"] = "HTML está";
$str["SMILIES"] = "Smilies";
$str["ARE"] = "estão";
$str["BBCODE"] = "código BB";
$str["IS"] = "está";
$str["EVENTCALENDAR"] = "Calendario de Eventos";
$str["EVENTDETAILS"] = "Detalhes do Evento";
$str["BACKTOCALENDAR"] = "Voltar ao Calendario";
$str["ADDEDBY"] = "Enviado por";
$str["VISITHOMEPAGE"] = "Visite o site de";
$str["ADDTOCONTACTLIST"] = "Adicionar a lista de Contactos";
$str["CLICKMEMBERPROFILE"] = "Click em ".makeimgtag($vwar_root . "images/button_profile.gif")." para ver o perfil dos membros";
$str["SHOWDETAILS"] = "Mostrar Detalhes";
$str["GAMES"] = "Jogo(s)";
$str["SENDMAILTO"] = "Enviar um eMail para";
$str["PROFILEOF"] = "Perfil de";
$str["PROFILELOCATION"] = "Local";
$str["PROFILEBIRTHDAY"] = "Aniversario";
$str["PROFILEINTERESTS"] = "Intereses";
$str["PROFILEGRAPHICCARD"] = "Placa Grafica";
$str["PROFILECONNECTION"] = "Ligação";
$str["PROFILEKEYBOARD"] = "Teclado";
$str["PROFILEMOUSE"] = "Rato";
$str["PHONENUMBERS"] = "Telefone";
$str["ONLYVISIBLETOMEMBERS"] = "Só visivel para membros";
$str["PHONE"] = "Telefone";
$str["CELLULARPHONE"] = "Telemovel";
$str["BACKTOWARLIST"] = "Voltar para Lista de Jogos";
$str["BACKTOMEMBERLIST"] = "Voltar para Lista de Membros";
$str["BACKTOWARDETAILS"] = "Voltar para Detalhes de Jogos";
$str["GAMESPLAYED"] = "Jogos Disputados";
$str["SHOWALL"] = "Mostrar tudo";
$str["ENTERNAME"] = "Intruduza o Nome";
$str["RESULTS"] = "Resultados";
$str["OTHERGAMESAGAINST"] = "Outros Jogos contra";
$str["PAGE"] = "Página";
$str["SORTTHISFIELDASC"] = "Ordem ascendente";
$str["SORTTHISFIELDDESC"] = "Ordem descendente";
$str["ASCENDING"] = "ascendente";
$str["DESCENDING"] = "descendente";
$str["CHALLENGE"] = "Desafio";
$str["GENERAL"] = "Geral";
$str["GAMETYPE"] = "Tipo de Jogo";
$str["MATCHTYPE"] = "Tipo de Desafio";
$str["SELECT"] = "Selecionar";
$str["ENTERTEAMNAME"] = "Inserir Nome de Equipa";
$str["ENTERSHORTTEAMNAME"] = "Inserir TAG de Equipa";
$str["ENTERCONTACTNAME"] = "Inserir Nome de Contacto";
$str["ENTERCONTACTEMAIL"] = "Inserir eMail de Contacto";
$str["CHALLENGEFORM"] = "Formulario do Desafio";
$str["TEAM"] = "Equipa";
$str["ADDITIONALINFOFULL"] = "Introduzir info adicional aqui (ex. configurações especiais) ou algo mais para alem dos dados fornecidos que seja de interesse para nos.";
$str["SELECTASMANY"] = "Selecione tantos quanto necessite";
$str["LOGGEDINAS"] = "Está identificado como";
$str["NOTLOGGEDIN"] = "Não está identificado";
$str["LOGIN"] = "Ligar";
$str["LOGIN2"] = "Ligar com utilizador e palavra-passe:";
$str["LOGOUT"] = "Desligar";
$str["DETAILS"] = "Detalhes";
$str["LANGUAGE"] = "Linguagem";
$str["LISTBYSTATUS"] = "Listar por Status";
$str["LISTBYTEAMS"] = "Listar por Equipas";
$str["LISTBY"] = "Listar por";
$str["PICTURE"] = "Imagem";
$str["NONPUBLICDETAILS"] = "Informação Privada <small>(só visivel para membros)</small>";
$str["FIRSTPAGE"] = "Primeira Pág.";
$str["LASTPAGE"] = "Ultima Pág.";
$str["PREVIOUSPAGE"] = "Pág. Anterior";
$str["NEXTPAGE"] = "Pág. Seguinte";
$str["ALL"] = "Tudo";
$str["SCORE"] = "Resultados";
$str["COUNTRY"] = "Pais";
$str["EDIT"] = "Editar";
$str["DELETE"] = "Apaguar";
$str["PERFORMDELETE"] = "Confirma Apagar ?";
$str["GUEST"] = "Convidado";
$str["REPORT"] = "Informar";
$str["BIRTHDAY"] = "Aniversario";
$str["JOINUS"] = "Junta-te a nos";
$str["JOINUSFORM"] = "Formulario";
$str["PERSONALDETAILS"] = "Detalhes Pessoais";
$str["JOINSUSADDITIONALINFO"] = "Descreva de uma forma breve porque se quer juntar á esquadra ou indique qualquer outra informação adicional de interesse para nós!";
$str["WEWILLCONTACTYOU"] = "Entramos em contacto o mais cedo possível";
$str["THANKSFORREQUEST"] = "Obrigado pelo seu pedido";
$str["EQUIPMENT"] = "Equipamento";
$str["GENERALINFORMATIONS"] = "Informação Geral";
$str["AGE"] = "Idade";
$str["ALLTIMESARE"] = "Todas as Horas são";
$str["TIMENOWIS"] = "A Hora actual é";
$str["STATUSWARS"] = "Combates sem Status";
$str["TODAYWARS"] = "Combates para Hoje";
$str["WARSSTATUS"] = "Status<br><smallfont>(alistados/necessarios)</smallfont>";
$str["ALLSTATUSSET"] = "Em todos os combates o status é ajustado";
$str["OWNGAMES"] = "Nossos Jogos";
$str["NOENTRY"] = "Nenhuma entrada Disponivel";
$str["SITEGENERATEDWITH"] = "Site gerado com";
$str["QUERYSIN"] = "Questionar em";
$str["SIMPLEMODE"] = "Modo Simples";
$str["ADVANCEDMODE"] = " Modo Avançado";
$str["CLOSECURRENTTAG"] = "Fechar o Tag actual";
$str["CLOSEALLTAGS"] = "Fechar todos os Tags";
$str["FORMATTEXT"] = "Coloque o texto que quer formatar:";
$str["FORMATTEXTADDITIONAL"] = "Coloque o texto que quer formatar - ";
$str["PROMPTLINKTEXT"] = "Coloque o texto que será visto no link (opcional):";
$str["PROMPTURLTEXT"] = "Coloque o URL completo para o link:";
$str["PROMPTMAILTEXT"] = "Coloque o endereço de email para o link";
$str["PROMPTLISTITEM"] = "Coloque um item da lista.\nDeixe a caixa vazia ou pressione 'Cancelar' para terminar a lista.";
$str["SIZE"] = "tamanho";
$str["HUGE"] = "enorme";
$str["BIG"] = "grande";
$str["NORMAL"] = "normal";
$str["SMALL"] = "pequeno";
$str["FONT"] = "fonte";
$str["COLOR"] = "cor";
$str["BOLDTEXT"] = "Texto Realçado";
$str["ITALICTEXT"] = "Texto Itálico";
$str["UNDERLINEDTEXT"] = "Texto Sublinhado";
$str["CENTER"] = "Centrado";
$str["CREATELIST"] = "Críe uma Lista";
$str["INSERTHYPERLINK"] = "Introduza um Hyperlink";
$str["INSERTCODE"] = "Introduza um Código";
$str["INSERTMAIL"] = "Introduza um endereço do email";
$str["INSERTQUOTE"] = "Introduza umas Citações";
$str["INSERTIMAGE"] = "Introduza uma Imagem";
$str["HELP"] = "Ajuda";
$str["CLICKONARROWTOINSERTCODE"] = "Click sobre a seta para introduzir o Código de BB.<br> Independente dos caracteres minusculos ou maiusculos, o URL é transformado automaticamente.";
$str["PLAY"] = "jogado ou para ser jogado";
$str["CANCELLED"] = "cancelado";
$str["OPPONENTLIST"] = "Lista Adversarios";
$str["MEMBERGALLERY"] = "Galeria de Membros";
$str["CONTACTLIST"] = "Lista de Contactos";
$str["RECEIVER"] = "Receptor";
$str["SENDERNAME"] = "Nome do Remetente";
$str["SENDERMAIL"] = "E-Mail do Remetente";
$str["SUBJECT"] = "Assunto";
$str["FORMAT"] = "Formato";
$str["MESSAGE"] = "Mensagem";
$str["CONTENT"] = "Conteudo";
$str["ENTER"] = "Enter";
$str["SEND"] = "Enviar";
$str["PRIORITY"] = "Prioridade";
$str["BACKTONEWS"] = "Voltar aos Detalhes da Notícia";
$str["QUOTE"] = "Citações";
$str["BACK"] = "Voltar atras";
$str["TITLE"] = "Titulo";
$str["NOICON"] = "Nenhum Ícone";
$str["PREVIEW"] = "Prever";
$str["TOTAL"] = "Total";
$str["GUESTBOOKOF"] = "Livro Convidados de";
$str["FUNCTIONDISABLED"] = "Esta função está <b>inibida</b>!";
$str["GOTO"] = "Ir&nbsp;para";
$str["PASSWORD"] = "Senha";
$str["FORGOTPASSWORD"] = "Esqueceu-se da Senha?";
$str["ARCHIVE"] = "Arquivo";
$str["CATEGORY"] = "Categoria";
$str["SEARCH"] = "Procura";
$str["ENLARGE"] = "Amplíe";
$str["PRINT"] = "Imprime";
$str["SUBMIT"] = "Submeta";
$str["REDIRECT"] = "Click aqui se você não quiser esperar mais tempo < br>(ou se seu browser não o enviar automaticamente)";
$str["ENTEREDREGISTEREDDATA"] = "Você colocou dados já registados (Nome, E-Mail). Substitua-os por valores não-registados!";
$str["SEARCHKEYWORD"] = "Pesquisar por palavra chave";
$str["SEARCHAUTHOR"] = "Pesquisar por autor";
$str["MATCHEXACTNAME"] = "Nome exacto do Match";
$str["MATCHPARTIALNAME"] = "Nome parcial do Match";
$str["USEWILDCARD"] = "Use * como <i>wildcard</i> para matches parciais";
$str["SEARCHOPTIONS"] = "Você pode usar <u>AND</u>, <u>OR</u> e <u>NOT</u> para buscas mais detalhadas";
$str["CONNECTSEARCHES"] = "Você pode ligar a Pesquisa por palavra chave com Pesquisa por autor";
$str["USEEXACTPHRASE"] = 'Texto entre duas " será Procurado como frase exacta';
$str["SEARCHIN"] = "Procura em";
$str["SEARCHFORRESULTSIN"] = "Procura por resultados em";
$str["DISPLAYMODE"] = "Modo de visualização";
$str["SEARCHINTEXT"] = "Procura no Texto";
$str["SEARCHINSUBJECT"] = "Procura no Assunto";
$str["SHOWASOVERVIEW"] = "Mostra como Vista Geral";
$str["SHOWINDETAILS"] = "Mostra nos Detalhes";
$str["SEARCHFORRESULTS"] = "Procura por resultados";
$str["SORTRESULTBY"] = "Classifica resultados por";
$str["OF"] = "de";
$str["LASTDAYS0"] = "qualquer data";
$str["LASTDAYS1"] = "ontem";
$str["LASTDAYS7"] = "última semana";
$str["LASTDAYS14"] = "últimas duas semanas";
$str["LASTDAYS30"] = "último mês";
$str["LASTDAYS90"] = "últimos tres meses";
$str["LASTDAYS180"] = "últimos seis meses";
$str["LASTDAYS365"] = "último ano";
$str["AND"] = "e";
$str["NEWER"] = "mais novo";
$str["OLDER"] = "mais velho";
$str["AUTHOR"] = "Autor";
$str["NUMLINKS"] = "Número de links";
$str["ADVANCEDSEARCH"] = "Procura Avançada";
$str["REQUIREDFIELDS"] = 'Os campos marcados com <font color="red">*</font> são requeridos';
$str["OR"] = "ou";
$str["LENGTHSEARCHWORD"] = "O comprimento da palavra a ser pesquisada deve ter no minimo 3 caracteres.";
$str["SEARCHINFORMATION"] = "Search Informação da Pesquisa";
$str["NEWSCOMMENTS"] = "Comentarios da Notícia";
$str["SENDNEWS"] = "Enviar a Notícia";
$str["RECEIVERMAIL"] = "E-Mail do Receptor";
$str["MOREFUNCTION"] = "Função-Mais: <b>activa</b><br>Você pode dividir seu conteúdo com";
$str["SUBMITTED"] = "(submetido)";
$str["AREYOUSURETODELETE"] = "Você tem a certeza que quer apagar o item selecionado?";
$str["NORMALMODE"] = "Modo Normal";
$str["LISTMODE"] = "Modo Lista";
$str["PROMPTLISTTYPE"] = "TiposLista: '1' = numerado, 'a' = letras pequenas,\n'I' = numeração romana, deixe em branco = bolinha";
$str["LASTEDITEDBY"] = "Last edited by";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "Livro de Convidados";

$str["GB_INFOLINE"] = "%1 %2 em %3 %4";

$str["GB_PAGE"] = "Página";

$str["GB_PAGES"] = "Páginas";

$str["GB_ENTRY"] = "Entrada";

$str["GB_ENTRIES"] = "Entradas";

$str["GB_ADDENTRY"] = "Adicionar Entrada";

$str["GB_ADDANENTRY"] = "Adicione uma entrada ao Livro de Convidados";

$str["GB_EDITENTRY"] = "Edite a Entrada";

$str["GB_EDITANENTRY"] = "Edite uma Entrada";

$str["GB_BACKTOGB"] = "Voltar ao Livro de Convidados";

$str["GB_WARNINGNAME"] = "Coloque um Nome por favor!";

$str["GB_WARNINGTEXT"] = "Coloque um Texto por favor!";

$str["GB_ADDNAME"] = "Nome";

$str["GB_ADDEMAIL"] = "eMail";

$str["GB_ADDHOMEPAGE"] = "Homepage";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "Titulo";

$str["GB_BLOCKED"] = "Você já escreveu uma entrada no/s ultimo/s <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Minuto";

$str["GB_MINUTES"] = "Minutos";

$str["GB_COMMENT"] = "Comentario";

$str["GB_COMMENTS"] = "Comentarios";

$str["GB_ENTRYBY"] = "Entrada no Livro de Convidados por";

## ---- END "GB" ---- ##
## ---- START "SPONSOR" ---- ##
$str["SPONSOR_CATEGORY"] = "Category";
$str["SPONSOR_SEARCH"] = "Search Sponsor";
$str["SPONSOR_NAME"] = "Links";
$str["SPONSOR_HITS"] = "Hits";
$str["SPONSOR_LANGUAGE"] = "Language";
$str["SPONSOR_OPTION"] = "Options";
$str["SPONSOR_DETAILS"] = "Details";
$str["SPONSOR_REDIRECT"] = "Click here if you do not want to wait any longer (or if your browser does not automatically forward you)";
$str["SPONSOR_LINKNAME"] = "Sponsorname";
$str["SPONSOR_HOMEPAGE"] = "Website";
$str["SPONSOR_DESCRIPTION"] = "Sponsor Description";
$str["SPONSOR_BACK"] = "Back";
$str["SPONSOR_BANNERURL"] = "Banner URL is incorrect";
$str["SPONSOR_BANNERNOT"] = "No Banner available";
## ---- END "SPONSOR" ---- ##

## ---- START "SEX" ---- ##
$sex_array = array(
	"me" => "Men",
	"wo" => "Women",
	"no" => "No comment",
);
$str["SEX"] = "Sex";
## ---- END "SEX" ---- ##
$str["WARTAG"]="War Tag";
## ---- END CUSTOM PART ---- ##
?>
