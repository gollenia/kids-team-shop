<?php

require __DIR__ . '/vendor/autoload.php';

use Contexis\Core\{
        Site,
        Router,
        Config,
        Controller
};



global $INPUT;

$site = new Site();
$route = new Router(Config::load("routes"));
$controller = Controller::get($route->get(), $site);

global $ID;

if($ID == "system") {
        p_set_metadata("programme:erzaehlungen:du_bist_wunderbar_gemacht:bilder_a3.pdf", ['downloads' => 57]);
p_set_metadata("programme:erzaehlungen:du_bist_wunderbar_gemacht:textheft_du_bist_wunderbar_gemacht.pdf", ['downloads' => 50]);
p_set_metadata("programme:erzaehlungen:du_bist_wunderbar_gemacht:bilder_a4.pdf", ['downloads' => 42]);
p_set_metadata("bausteine:spiele:auf_zum_gipfel_resilienzspiel:spielkarten_farbe.pdf", ['downloads' => 24]);
p_set_metadata("bausteine:spiele:auf_zum_gipfel_resilienzspiel:auf_zum_gipfel_resilienzspiel_spielanleitung.pdf", ['downloads' => 	24]);
p_set_metadata("bausteine:spiele:ostereiersuche:die_etwas_andere_ostereiersuche.pdf", ['downloads' => 	22]);
p_set_metadata("programme:erzaehlungen:barak_und_das_kreuz:barak_und_das_kreuz_lektionsbilder.pdf", ['downloads' => 	22]);
p_set_metadata("programme:kinderstunden:natur_pur:natur_pur_kindertreffen.pdf", ['downloads' => 	21]);
p_set_metadata("programme:kinderstunden:dein_koenig_kommt:dein_koenig_kommt_basteln_und_spiele.pdf", ['downloads' => 	21]);
p_set_metadata("programme:erzaehlungen:du_bist_wunderbar_gemacht:ausmalbild.pdf", ['downloads' => 	19]);
p_set_metadata("programme:erzaehlungen:barak_und_das_kreuz:barak_und_das_kreuz_textheft.pdf", ['downloads' => 	15]);
p_set_metadata("programme:kinderwochen:detekive_auf_heisser_spur:0_allgemeines.zip", ['downloads' => 	14]);
p_set_metadata("videos:kinder:aufderspur:teil_3:auf_der_spur_basteln_3.pdf", ['downloads' => 	16]);
p_set_metadata("programme:kinderstunden:dein_koenig_kommt:dein_koenig_kommt_textheft.pdf", ['downloads' => 	12]);
p_set_metadata("bausteine:spiele:auf_zum_gipfel_resilienzspiel:spielplan_a3.pdf", ['downloads' => 	12]);
p_set_metadata("videos:onlineseminare:loewenzahn_steckbrief:loewenzahn_steckbrief.pdf", ['downloads' => 	12]);
p_set_metadata("programme:kinderwochen:kampf_um_dolwydenburgh:1_tag_1.zip", ['downloads' => 	11]);
p_set_metadata("programme:kinderstunden:dein_koenig_kommt:dein_koenig_kommt_lektionsbilder.pdf", ['downloads' => 	11]);
p_set_metadata("videos:kinder:aufderspur:teil_2:auf_der_spur_basteln_2.pdf", ['downloads' => 	11]);
p_set_metadata("bausteine:basteln:gummibaerli-kekse:gummibaerli-kekse.pdf", ['downloads' => 	10]);
p_set_metadata("programme:kleinekids:1:die_schoepfung:kleinekids_bibelset_schöpfung.zip", ['downloads' => 	10]);
p_set_metadata("programme:kinderwochen:detekive_auf_heisser_spur:1_naaman.zip", ['downloads' => 	13]);
p_set_metadata("bausteine:lieder:ich_gehoer_zu_gott:ich-gehoer-zu-gott_1joh_4v4.pdf", ['downloads' => 	9]);
p_set_metadata("programme:kleinekids:1:der_suendenfall:kleinekids-bibelset-sündenfall.zip", ['downloads' => 	9]);
p_set_metadata("bausteine:lieder:ich_liebe_die_mich_lieben:ich_liebe_die_mich_lieben_sprueche_8_17_noten.pdf", ['downloads' => 	8]);
p_set_metadata("bausteine:lieder:meine_hilfe_kommt_vom_herrn:meine-hilfe-kommt-vom-herrn_ps121v2_noten.pdf", ['downloads' => 	8]);
p_set_metadata("bausteine:basteln:gebetsuhr_gottes_eigenschaften:gebetsuhr_ausmalen.pdf", ['downloads' => 	8]);
p_set_metadata("bausteine:lieder:nur_jesus_kann:nur_jesus_kann_apostelgeschichte_4_12_noten.pdf", ['downloads' => 	8]);
p_set_metadata("programme:kinderwochen:seefahrer_entdecker:kiwo_seefahrer_entdecker.zip", ['downloads' => 	7]);
p_set_metadata("videos:kinder:aufderspur:teil_1:auf_der_spur_basteln_1.pdf", ['downloads' => 	14]);
p_set_metadata("bausteine:spiele:auf_zum_gipfel_resilienzspiel:spielplan_2teilig.pdf", ['downloads' => 	7]);
p_set_metadata("programme:kleinekids:1:die_schoepfung:bibelset_schöpfung_-_uebersicht.pdf", ['downloads' => 	7]);
p_set_metadata("videos:kinder:mutig_mutiger_muttier:honigdachs:honigdachs.pdf", ['downloads' => 	7]);
p_set_metadata("bausteine:lieder:gott_sah_alles_an:noten_gott_sah_alles_an_1.mose_1_31_pdf", ['downloads' => 	7]);
p_set_metadata("bausteine:lieder:ich_gehoer_zu_gott:ich_gehoer_zu_gott_1._johannes_4_4_noten.pdf", ['downloads' => 	7]);
p_set_metadata("programme:kinderwochen:kampf_um_dolwydenburgh:5_tag_5.zip", ['downloads' => 	7]);
p_set_metadata("bausteine:basteln:10_dinge_aus_klopapierrollen:10_dinge_klopapierrollen.pdf", ['downloads' => 	7]);
p_set_metadata("videos:kinder:mutig_mutiger_muttier:packesel:packesel_vorlage.pdf", ['downloads' => 	7]);
p_set_metadata("bausteine:basteln:gebetsuhr_gottes_eigenschaften:gebetsuhr_bunt.pdf", ['downloads' => 	6]);
p_set_metadata("programme:kinderstunden:kuerbisfest:infoblatt_kuerbisfest.pdf", ['downloads' => 	6]);
p_set_metadata("bausteine:lieder:gott_sah_alles_an:gott-sah-alles-an_1mose1v31_neu.pdf", ['downloads' => 	6]);
p_set_metadata("videos:kinder:wikinger-woche:armbaender:wikinger-armbaender.pdf", ['downloads' => 	6]);
p_set_metadata("programme:kinderwochen:detekive_auf_heisser_spur:5_der_verlorene_sohn.zip", ['downloads' => 	6]);
p_set_metadata("videos:kinder:mutig_mutiger_muttier:kondor:kondor.pdf", ['downloads' => 	6]);
p_set_metadata("videos:kinder:mutig_mutiger_muttier:esel:esel.pdf", ['downloads' => 	6]);
p_set_metadata("bausteine:lieder:alle_die_meine_worte_hoeren:alle_die_meine_worte_hoeren_lukas_11_28_noten.pdf", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:nur_jesus_kann:nur-jesus-kann_apg_4v12.pdf", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:herr_du_bist_so_gut:herr-du-bist-so-gut_ps86v5_noten.pdf", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:du_erhoerst_meine_gebete:noten_du_erhoerst_meine_gebete-psalm_65v3.pdf", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:gehoert_jemand_zu_gott:gehoert_jemand_zu_jesus_christus_2kor_5v17.pdf", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:alle_die_meine_worte_hoeren:alle_die_meine_worte_hoeren_lukas_11v28.pdf", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:wo_ist_ein_gott_wie_du:noten_wo_ist_ein_gott_wie_du_micha_7_18_pdf", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:gott_haelt_was_er_verspricht:gott_haelt_was_er_verspricht_5._mose_32_4_noten.pdf", ['downloads' => 	5]);
p_set_metadata("videos:kinder:mutig_mutiger_muttier:honig-limo:honig-limo.pdf", ['downloads' => 	6]);
p_set_metadata("videos:kinder:mutig_mutiger_muttier:gleitschirm:gleitschirm.pdf", ['downloads' => 	5]);
p_set_metadata("programme:kinderstunden:thomas_vom_zweifel_zum_glauben:1_textheft.zip", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:jesus_ist_gekommen:jesus_ist_gekommen_lukas19v10.pdf", ['downloads' => 	5]);
p_set_metadata("programme:kinderwochen:kampf_um_dolwydenburgh:0_allgemeines.zip", ['downloads' => 	5]);
p_set_metadata("bausteine:lieder:du_erhoerst_meine_gebete:du_erhoerst_meine_gebete-psalm_65v3.pdf", ['downloads' => 	5]);
p_set_metadata("programme:erzaehlungen:flucht_nach_aegypten:4_landkarte_flucht_nach_aegypten.zip", ['downloads' => 	4]);
p_set_metadata("bausteine:lieder:ich_liebe_die_mich_lieben:ich_liebe_die_mich_lieben_sprueche_8v17.pdf", ['downloads' => 	4]);
p_set_metadata("programme:erzaehlungen:flucht_nach_aegypten:2_erzaehlzeitung.zip", ['downloads' => 	4]);
p_set_metadata("bausteine:lieder:wo_ist_ein_gott_wie_du:wo-ist-ein-gott-wie-du_micha7v18.pdf", ['downloads' => 	4]);
p_set_metadata("bausteine:basteln:salzteig-herzen:salzteig-herz.pdf", ['downloads' => 	4]);
p_set_metadata("programme:kinderwochen:detekive_auf_heisser_spur:lieder-detektivwoche.zip", ['downloads' => 	4]);
p_set_metadata("programme:kinderwochen:detekive_auf_heisser_spur:3_rut.zip", ['downloads' => 	4]);
p_set_metadata("programme:kinderstunden:thomas_vom_zweifel_zum_glauben:2_kopiervorlagen_a3.zip", ['downloads' => 	4]);
p_set_metadata("bausteine:lieder:kinderzeltsong:kinderzeltsong.pdf", ['downloads' => 	4]);
p_set_metadata("bausteine:basteln:das_leere_grab:das_leere_grab.pdf", ['downloads' => 	4]);
p_set_metadata("programme:kinderstunden:einladung_fuer_osterkinderstunde:1_ostern_einladung_1x_a5.pdf", ['downloads' => 	4]);
p_set_metadata("programme:kinderstunden:einladung_fuer_osterkinderstunde:2_ostern_einladung_2x_auf_a4.pdf", ['downloads' => 	4]);
p_set_metadata("bausteine:lieder:gott_haelt_was_er_verspricht:gott_haelt_was_er_verspricht_5mose_32v4.pdf", ['downloads' => 	4]);
p_set_metadata("bausteine:lieder:gehoert_jemand_zu_gott:gehoert_jemand_zu_jesus_christus_2._korinther_5_17_noten.pdf", ['downloads' => 	4]);
p_set_metadata("bausteine:basteln:auferstehungsweckerl:auferstehungsweckerl.pdf", ['downloads' => 	4]);
p_set_metadata("programme:kinderstunden:einladung_fuer_osterkinderstunde:1_ostern_einladung_2x_auf_a4.pdf", ['downloads' => 	3]);
p_set_metadata("programme:kinderwochen:kampf_um_dolwydenburgh:allgemeines.zip", ['downloads' => 	3]);
p_set_metadata("programme:kleinekids:1:der_suendenfall:bibelset_sündenfall_-_uebersicht.pdf", ['downloads' => 	3]);
p_set_metadata("programme:kinderstunden:thomas_vom_zweifel_zum_glauben:3_kopiervorlagen_a4.zip", ['downloads' => 	3]);
p_set_metadata("bausteine:spiele:auf_zum_gipfel_resilienzspiel:spielkarten_farblos.zip", ['downloads' => 	3]);
p_set_metadata("bausteine:basteln:ostergarten_und_osterlamm:1-19.pdf", ['downloads' => 	3]);
p_set_metadata("programme:kinderstunden:kuerbisfest:einladung_kuerbisfest.pdf", ['downloads' => 	3]);
p_set_metadata("programme:kleinekids:1:turmbau_zu_babel:kleinekids-bibelset-turmbau-zu-babel.zip", ['downloads' => 	3]);
p_set_metadata("bausteine:lieder:herr_du_bist_so_gut:herr_du_bist_so_gut-psalm_86v5.pdf", ['downloads' => 	3]);
p_set_metadata("bausteine:lieder:meine_hilfe_kommt_vom_herrn:psalm_121v2_meine-hilfe-kommt-vom-herrn.pdf", ['downloads' => 	3]);
p_set_metadata("videos:kinder:aufderspur:teil_5:auf_der_spur_basteln_5.pdf", ['downloads' => 	3]);
p_set_metadata("videos:kinder:mutig_mutiger_muttier:scheibenbauch:scheibenbauch.pdf", ['downloads' => 	3]);
p_set_metadata("videos:onlineseminare:mit_buntstiften_zum_bibelentdecker:mit_dem_buntstift_bibel_lesen.pdf", ['downloads' => 	2]);
p_set_metadata("programme:erzaehlungen:flucht_nach_aegypten:3_kinderheft.zip", ['downloads' => 	2]);
p_set_metadata("programme:erzaehlungen:flucht_nach_aegypten:1_allgemeines.zip", ['downloads' => 	2]);
p_set_metadata("programme:erzaehlungen:flucht_nach_aegypten:5_kopiervorlagen.zip", ['downloads' => 	2]);
p_set_metadata("programme:kleinekids:1:jesus_war_ein_mensch:kleinekids_bibelset_jesus_war_ein_mensch.zip", ['downloads' => 	2]);
p_set_metadata("programme:kinderwochen:detekive_auf_heisser_spur:2_zach_aeus.zip", ['downloads' => 	2]);
p_set_metadata("bausteine:lieder:jesus_ist_gekommen:noten_jesus_ist_gekommen_lukas19v10.pdf", ['downloads' => 	2]);
p_set_metadata("videos:kinder:mutig_mutiger_muttier:essbarer_schleim:essbarer_schleim.pdf", ['downloads' => 	2]);
p_set_metadata("programme:kinderwochen:kampf_um_dolwydenburgh:2_tag_2.zip", ['downloads' => 	2]);
p_set_metadata("programme:kinderstunden:kuerbisfest:faltbilderbuch_kuerbisfest.pdf", ['downloads' => 	2]);
p_set_metadata("videos:kinder:wikinger-woche:fladenbrot:wikinger-fladenbrot.pdf", ['downloads' => 	2]);
p_set_metadata("programme:kinderwochen:seefahrer_entdecker:kiwo_seefahrer_entdecker_layoutelemente.zip", ['downloads' => 	2]);
p_set_metadata("programme:kinderwochen:kampf_um_dolwydenburgh:4_tag_4.zip", ['downloads' => 	2]);
p_set_metadata("programme:kleinekids:1:weihnachten:bibelset-weihnachten-hirten.zip", ['downloads' => 	1]);
p_set_metadata("programme:kleinekids:1:jesus_war_ein_mensch:00_bibelset_jesus_war_ein_mensch_-_uebersicht.pdf", ['downloads' => 	1]);
p_set_metadata("videos:kinder:wikinger-woche:wikinger-schiff:wikingerschiff.pdf", ['downloads' => 	1]);
p_set_metadata("videos:kinder:wikinger-woche:wikinger-muehle:wikinger-muehle.pdf", ['downloads' => 	1]);
p_set_metadata("programme:kleinekids:1:noah:kleinekids-bibelset-noah.zip", ['downloads' => 	1]);
p_set_metadata("videos:kinder:aufderspur:teil_4:auf_der_spur_basteln_4.pdf", ['downloads' => 	1]);
p_set_metadata("programme:kinderwochen:detekive_auf_heisser_spur:4_petrus_im_gef_aengnis.zip", ['downloads' => 	1]);
p_set_metadata("programme:kleinekids:1:noah:bibelset_noah_-_uebersicht.pdf", ['downloads' => 	1]);

}

// important function to build the index etc.
