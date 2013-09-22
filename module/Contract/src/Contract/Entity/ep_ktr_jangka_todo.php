<?php

class ep_ktr_jangka_todo extends MY_Model
{
    public $table = 'EP_KTR_JANGKA_KONTRAK';
    public $sql_select = "(     
                                SELECT a.kode_jangka, a.kode_kontrak, a.kode_kantor
                                    , b.kode_vendor, b.no_kontrak, b.tgl_ttd, a.persentasi, a.tgl_target
                                    , a.persentasi_perkembangan,  a.keterangan
                                    , x.URL
                                    , x.KODE_PROSES
                                    , x.NAMA_AKTIFITAS
                                    , '' as ACT
                                FROM ep_ktr_jangka_kontrak a
                                INNER JOIN ep_ktr_kontrak b ON a.kode_kontrak = b.kode_kontrak and a.kode_kantor = b.kode_kantor
                                LEFT OUTER JOIN (
                                    select a.* ,c.NAMA_AKTIFITAS, b.url, d.KODE_JANGKA, KODE_KONTRAK, KODE_KANTOR, KODE_VENDOR, KODE_TENDER, KODE_INVOICE
                                    from EP_WKF_PROSES a
                                    inner join (
                                        select rtrim(xmlagg(xmlelement(e, '&' || key || '=' || value )).extract('//text()').extract('//text()') ,',') url, kode_proses 
                                        from EP_WKF_PROSES_VARS
                                        group by KODE_PROSES
                                    ) b on a.kode_proses = b.kode_proses
                                    inner join EP_WKF_AKTIFITAS c on A.KODE_AKTIFITAS = C.KODE_AKTIFITAS
                                    inner join (
                                        select a.kode_proses,
                                                MAX(CASE WHEN b.key = 'KODE_JANGKA' THEN b.value ELSE NULL END) AS KODE_JANGKA,
                                                MAX(CASE WHEN b.key = 'KODE_KONTRAK' THEN b.value ELSE NULL END) AS KODE_KONTRAK,
                                                MAX(CASE WHEN b.key = 'KODE_KANTOR' THEN b.value ELSE NULL END) AS KODE_KANTOR,
                                                MAX(CASE WHEN b.key = 'KODE_VENDOR' THEN b.value ELSE NULL END) AS KODE_VENDOR,
                                                MAX(CASE WHEN b.key = 'KODE_TENDER' THEN b.value ELSE NULL END) AS KODE_TENDER,
                                                MAX(CASE WHEN b.key = 'KODE_INVOICE' THEN b.value ELSE NULL END) AS KODE_INVOICE
                                        from ep_wkf_proses a
                                        inner join ep_wkf_proses_vars b on a.kode_proses = b.kode_proses
                                        group by a.kode_proses
                                    ) d on a.kode_proses = d.kode_proses
                                    where kode_wkf = 61 and tanggal_selesai is null
                                ) x ON a.kode_kontrak = x.KODE_KONTRAK and a.KODE_JANGKA = x.KODE_JANGKA and a.KODE_KANTOR = x.KODE_KANTOR 
                                where (x.KODE_KONTRAK is null or x.kode_aplikasi = 2) 
                                and b.status = 'O' 
                                and b.tipe_kontrak = 'RENTAL SERVICE'
                                and ( status_bastp <> 'O' or status_bastp is null )
                          )";
    public $columns_conf = array(
        'KODE_JANGKA',
        'KODE_VENDOR',
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'NO_KONTRAK',
        'TGL_TTD',
        'KETERANGAN',
        'PERSENTASI',
        'TGL_TARGET',
        'PERSENTASI_PERKEMBANGAN',
        
        'KODE_PROSES',
        'NAMA_AKTIFITAS',
        'URL',
        'ACT',
    );
    public $dir = 'top';

    function __construct()
    {
        parent::__construct();
        $this->init();

        $this->js_grid_completed = '
                var ids = jQuery(\'#grid_' . strtolower(get_class($this)) . '\').jqGrid(\'getDataIDs\');
		for(var i=0;i < ids.length;i++){
                    var cl = ids[i];
                    
                    var data = jQuery(\'#grid_' . strtolower(get_class($this)) . '\').jqGrid(\'getRowData\', cl);
                    
                    //alert(data[\'KODE_PROSES\']);
                    
                    var param = "referer_url=/contract/top/list_todo&KODE_JANGKA=" + data[\'KODE_JANGKA\']
                    + "&KODE_KANTOR=" + data[\'KODE_KANTOR\']
                    + "&KODE_KONTRAK=" + data[\'KODE_KONTRAK\']
                    + "&KODE_VENDOR=" + data[\'KODE_VENDOR\'];
                    
                    var href = $site_url + "/contract/top/create_draft?" + param;
                    
                    if(data[\'URL\'].length > 0)
                        var href = $site_url + "/wkf/run?kode_wkf=61&kode_proses=" +data[\'KODE_PROSES\'] +"&"+ param;
                    else
                        var href = $site_url + "/wkf/start?kode_wkf=61&" + param;
                    
                    be = "<button onclick=\"javascript:window.location=\'" +href+ "\'\" type=\"button\" id=\"btnProses\" class=\"ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" role=\"button\" aria-disabled=\"false\"><span class=\"ui-button-text\">PROSES</span></button>";
                    jQuery(\'#grid_' . strtolower(get_class($this)) . '\').jqGrid(\'setRowData\',ids[i],{ACT:be});
		}';
    }
    
    function _default_scope() {
        parent::_default_scope();
        
        return " KODE_VENDOR = " . $this->session->userdata('kode_vendor');
    }
}
?>