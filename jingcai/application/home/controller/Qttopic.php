<?php

namespace app\home\Controller;

use think\DB;
use think\Controller;
use think\Session;
use think\Url;

class Qttopic extends \app\mobile\controller\base\Base
{

    function index()
    {


        $zhuanti = array(
            'A-安徽' => array(
                1=>array('合肥车之良品汽车服务有限公司','安徽省合肥市瑶海区铜陵北路馥邦汽车城北大门东侧','0551-64286366')),
            'C-重庆' => array(
                1=>array('万州区钟鼓楼友联凯旋汽车美容服务部','重庆市万州区北山大道306号附1号','023-58881618')),
            'F-福建' => array(
                1=>array('福州广度电子技术服务有限公司','福建省福州市仓山区建新北路142号奋安产业园M区103','15880040181'),
                array('三明市佳友贸易有限公司','福建省三明市新市北路乾龙新村99幢底层8—15号（商检局正对面）','0598-8256268'),
                array('莆田市城厢区小鸭汽车美容服务站','总店：福建省莆田市涵江区涵华东路1451号<br>分店1：福建省莆田市荔城区胜利北路1628号<br>分店2：福建省莆田市城厢区人民政府斜对面（万达广场旁启迪国际社区）<br>分店3：福建省莆田市涵江区六一路（民生银行对面）小鸭汽车美容','0594-3566168<br>分店3：0594-3599168'),
                array('莆田市城厢区小鸭汽车美容服务站','福建省莆田市城厢区荔华东大道（小鸭汽车美容）','0594-2602260')
            ),
            'G-广东' => array(
                1=>array('顺德区大良精贴汽车用品店','广东省佛山市顺德区大良文晖路29号逸林苑41号商铺','0757-28099292')),
            'G-广西' => array(
                1=>array('广西北海漆世界汽车服务有限公司','总店：广西省北海市海城区贵州路20号<br>分店1：广西北海市海城区北部湾东路33号大院','0779-3066887/0779-2052308'),
                array('横县金山车饰美容用品中心一分店','广西省南宁市横县长安路119号（金山车饰）','0771-7203002/0771-7083308'),
                array('桂林市天成车业服务有限责任公司','总店：广西桂林市叠彩区中山北路136号北仓路口天成车业叠彩万达店<br>1店：广西省桂林市八里街五纬路口(八里街威固专营店)<br>2店：广西省桂林市临桂县世纪大道交通大厦1楼(临桂分公司)<br>3店：广西省桂林市崇信路50-1号(南溪店)<br>4店：广西省桂林市高新区毅峰路20号唐明瑶','0773-2825777<br/>4店：0773-2536566/15207736099')
            ),
            'G-贵州' => array(
                1=>array('贵阳花溪亿滋汽车服务有限公司','贵州省贵阳市南明区沙冲南路78号绿苑小区入口','0851-83809277')),
            'H-河北' => array(
                1=>array('河北卓奥自动化设备科技有限公司','武安市建设大街武安市向阳路80号邯郸市北环路与滏西大街交叉口南行150米路东','0310-3088118')),
            'H-河南' => array(
                1=>array('长垣县怒马汽车维修中心','新乡市长垣县浦西区卫华大道宏力新村一期7号商铺','15903872222'),
                array('商丘市睢阳区方正汽车装饰美容中心','河南省商丘市睢阳区文化路与金银路交叉口加油站对面路南','0370-2790369'),
                array('许昌经济技术开发区嘉欣汽车装饰部','许昌市魏都区延安北路魏都汽贸城对面','0374--2622166'),
                array('郑州市金水区港威汽车装饰城','郑州市金水区东风路20号','0371-65821777/65722777')
            ),
            'H-湖北' => array(
                1=>array('十堰长荣汽车服务有限公司','湖北省十堰市茅箭区朝阳南路5号','0719-8689890'),
                array('枝江市张友谊汽修服务部','湖北省枝江市友谊大道电信大楼一楼','0717-4225885'),
                array('武汉领驾汽车服务有限公司','总店地址：武汉市硚口区建设大道333号<br>分店1地址：武汉红旗渠路阳光花园小区1栋','027-83613559')
            ),
            'H-湖南' => array(
                1=>array('益阳市朝阳汇丰汽车服务中心','益阳市益阳大道西416号','0737-4229511'),
                array('岳阳市南湖新区永豪汽车养护装饰美容中心','岳阳市求索东路393号','0730-8625122'),
                array('株洲市天元区巧手汽车服务会所','总店：株洲市天元区海诚路111号<br>分店1：株洲市天元区株洲大道188号<br>分店2：芦淞区湘江四季花园分店3：荷塘区红旗路','0731-28817588/0731-22152898/0731-22428068/0731-22880498/0731-28626639'),
                array('常德市鹏驰汽车服务有限公司','常德市武陵区洞庭大道中段100号','0736-7719663')
            ),
            'J-江苏' => array(
                1=>array('苏州诺卡贸易有限公司','连云港市海州区解放东路318号振兴汽车城院内奇瑞4s店后面','0512-89990520'),
                array('江都区名车苑汽车服务部','扬州市江都区城北长江国际花园西门对面','0514-86823548'),
                array('无锡市威固汽车服务有限公司','总店地址：锡山经济开发区锡沪东路88号6区F栋18号（东区）<br>分店1地址：无锡市锡山区东港镇香山路<br>分店2地址：江阴市长径镇工业园B区<br>分店3地址：无锡市江海西路与钱威路交叉口原蒙利建设','0510-88786985'),
                array('无锡百特威蠡园汽车维修服务有限公司','江苏省无锡市滨湖区蠡园开发区A4底楼东','0510-85165160'),
                array('武进区湖塘卡卡高瑞汽车用品超市','江苏省常州市武进区湖塘镇夏城南路208号高力汽博城A区3幢118号','0519-88058176'),
                array('徐州涅槃汽车服务有限公司','徐州市泉山区泰山路70-1号','18651777886'),
                array('镇江市润州新君威车饰行','江苏省镇江市运河路东方花苑2号','0511-84449831'),
                array('滨湖区美车坊汽车装潢店','无锡市滨湖区大通路梁南苑26-1','0510-85069197'),
                array('扬州市硕添商贸有限公司','扬州市开发区邗江中路150号康桥花园门面','18012127198')
            ),
            'J-江西' => array(
                1=>array('南昌和众贸易有限公司','江西省南昌市青山湖区南京东路1007号（南昌维众）','0791-87067375')),
            'L-辽宁' => array(
                1=>array('沈阳万通汇丰经贸有限公司','店面：沈阳万通汇丰经贸有限公司地址：沈阳市铁西区北三东路9','024-25556666'),
                array('兴城市名车汇汽车装饰商行','辽宁省葫芦岛市兴城市温泉办事处干休所综合楼A3号','18504294555'),
                array('丹东市元宝区雨辰汽车美容服务部','辽宁省丹东市元宝区宝山大街6-2号','0415-3828778'),
                array('庄河市平安汽车美容','辽宁省大连市庄河市延安路平安汽车美容（庄河市新三十一中对面）','0411-89259888'),
                array('辽阳市白塔区三九车仆汽车美容服务中心','总店：辽宁省辽阳市白塔区富虹阳光尊邸10-8号<br>分店：辽阳市辽阳县首山镇辽鞍路79-1号','0419-2277755'),
                array('辽阳县方程式汽车服务中心','辽宁省辽阳市辽阳县首山镇辽鞍路79-1号','0419-6288999'),
                array('海城市兴海管理区鲍哥汽车用品商行','辽宁省海城市铁西祥圣转盘南18米路西','0412-3160078')
            ),
            'N-内蒙' => array(
                1=>array('鄂托克前旗南洋汽车美容会所','鄂尔多斯市鄂托克前旗敖镇沙日塔拉西街（公交公司门口）'),
                array('集宁区永江汽车装璜部','乌兰察布市集宁区兴工路战役馆对面永江车饰威固专营店','13947426388')
            ),
            'S-上海' => array(
                1=>array('上海市闵行区路炫汽车用品经营部','上海市闵行区金都路2005-2009号','13764758458'),
                array('上海市浦东新区金杨街道德宝汽车装饰用品经营部','上海市浦东新区栖山路1602号','021-50343868')
            ),
            'S-四川' => array(
                1=>array('四川车之友汽车服务有限公司','四川省德阳市庐山南路203号（庐山路与西湖路交叉口的东北角位置上）','0838-2505359'),
                array('华蓥市全车得汽车生活馆','四川省华蓥市蓥光路名盛楼','0826-4833246'),
                array('天府新区华阳盛世华美汽车美容装饰部','成都市天府新区华阳二江路二段131、133、137号-2号','028-85822596'),
                array('广汉市洁美汽车美容养护站','四川省广汉市湘潭路西三段（益海粮油对面）','0838-5302988'),
                array('阆中市骑士精典汽车装饰门市部','四川省阆中市保宁醋东街8号','0817-6259699'),
                array('达县南外卡仕邦汽车用品经营部','达州市达川区商贸物流园区莱克汽贸园汽配区6栋1/2号-1号','18084992991')
            ),
            'X-新疆' => array(
                1=>array('新市区河北东路卡卡汽车服务部','总店地址：乌鲁木齐赛博特汽车城C区C15-2<br>分店1地址：乌鲁木齐新市区河北东路康城果岭小区底商<br>分店2地址：乌鲁木齐水磨沟区昆仑路映像南湖小区底商','0991-66253752/0991-66989583/0991-4872180'),
                array('沙湾县车冠汽车服务有限公司','新疆塔城地区沙湾县S115省道沙湾汽贸园A区01楼04号商铺','0993-6097188'),
                array('库尔勒万通汽车服务有限责任公司','库尔勒市朝阳路-2号','0996-2255755'),
                array('新市区阿勒泰路美美车城汽车美容会所','乌鲁木齐市新市区阿勒泰路2358号','0991-7862333'),
                array('乌鲁木齐市米东区伴侣汽车用品中心','新疆维吾尔族自治区米东区龙河路三建路口498号','0991-3318588'),
                array('阿克苏市弘鑫汽车美容服务中心','新疆阿克苏市南城街道塔城南路钢材市场6-7号','15770005333')
            ),
            'Z-浙江' => array(
                1=>array('温州市汽配市场日铃汽配商行','浙江省温州市鹿城区龙方路汽配市场5-7号','0577-88899610'),
                array('杭州利澳佳德汽车服务有限公司','浙江省杭州市下城区绍兴路341号'),
                array('绍兴三陆丽汽车装饰有限公司','总店：浙江省绍兴市柯桥兴越路现代大厦1号楼西侧<br>分店1：浙江省绍兴市柯桥区钱清镇大钱门小区1-0106','0575-84785666<br>分店2：0575-85594566'),
                array('杭州市滨江区车韵汽车用品商行','总店：浙江省杭州市滨江区江南大道3672-1号、3672-2号<br>分店：浙江省杭州市余杭区文一西路833号大华西溪风情北会所地下室','0571-28212007'),
                array('绍兴市柯桥区恒宾汽车美容装饰有限公司','浙江省绍兴市柯桥区南闲路777号','057-584116263'),
                array('杭州盛慈汽车服务有限公司','浙江省杭州市拱墅区塘萍路421号','15058159659'),
                array('杭州前健贸易有限公司','浙江省杭州市滨江区仁苑商铺14、15号','15805819993'),
                array('杭州久丰汽车用品有限公司','浙江省杭州市拱墅区石祥路589号汽车城南十四通道3339号','0571-28811106'),
                array('余姚市弗客世家汽车装潢有限公司','浙江省余姚市阳明街道康山村龙头22号','0574-62892389'),
                array('杭州好景贸易有限公司','浙江省杭州市滨江区南环路3192号','18268852680'),
                array('宁波朋源汽车修理服务有限公司','浙江省宁波市云林东路1号','0574-87006711'),
                array('建德市新安江街道利达汽车美容装饰行','浙江省建德市新安东路423号','0571-64723307'),
                array('武义君泰汽车美容装饰店','浙江省武义市东升东路与宝塔路交叉口（法院对面）','0579-87878989')
            ),
        );
        $this->assign('zhuanti', $zhuanti);
        return $this->fetch();
    }
}